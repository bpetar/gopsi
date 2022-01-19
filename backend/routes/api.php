<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\User;
use App\Task;
use App\Author;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;

use App\Http\Controllers\Log;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::middleware('auth:airlock')->get('/user', function (Request $request) {
    return $request->user();
});

/*Route::middleware('auth:airlock')->get('/tasks', function (Request $request) {
    return Task::all();
});*/

Route::middleware('auth:airlock')->get('/dones/{client_id}', function (Request $request, $client_id) {
    \Log::info('Dones se api ruta task: ' . $client_id);
    $author_id = $request->user()->authors()->first()->user_id;
    
    // Decrypt crucial values from DB
    $tasks = Task::where('client_id', $client_id)->where('author_id', $author_id)->where('status', 'done')->get();
    foreach ($tasks as $doneTask) {
        if ($doneTask->title) {
            try {
                $decryptedTitle = Crypt::decryptString($doneTask->title);
            } catch (DecryptException $e) {
                $decryptedTitle = "Task title was corrupted!";
            }
            $doneTask->title = $decryptedTitle;
        }
        if ($doneTask->description) {
            try {
                $decryptedDescription = Crypt::decryptString($doneTask->description);
            } catch (DecryptException $e) {
                $decryptedDescription = "Task description was corrupted!";
            }
            $doneTask->description = $decryptedDescription;
        }
        if ($doneTask->client_notes) {
            try {
                $decryptedCN = Crypt::decryptString($doneTask->client_notes);
            } catch (DecryptException $e) {
                $decryptedCN = "Task client notes were corrupted!";
            }
            $doneTask->client_notes = $decryptedCN;
        }
    }

    return $tasks;
});

Route::middleware('auth:airlock')->put('/tasks/{task}',  function (Request $request, Task $task) {
    
    \Log::info('Called api route put task: ' . $task->author_id);
    $putData = $request->all();

    // ENCRYPT sensitive data here
    if ($putData['client_notes']) {
        $request->merge(['client_notes' => Crypt::encryptString($putData['client_notes'])]);
    }
    if ($putData['description']) {
        $request->merge(['description' => Crypt::encryptString($putData['description'])]);
    }
    if ($putData['title']) {
        $request->merge(['title' => Crypt::encryptString($putData['title'])]);
    }

    $task->update($request->all());

    $user = User::where('id', $task->client_id)->first();
    $userAuthor = User::where('id', $task->author_id)->first();
    $taskTitle = $putData['title'];
    \Log::info('ako je done, saljemo mail authoru: ' . $putData['status'] . ' email: ' . $userAuthor->email);
    if ($putData['status'] == 'done') {
        Mail::send([], [], function ($message) use ($user, $userAuthor,$taskTitle) {
          $message->to($userAuthor->email)
            ->subject('User ' . $user->name . ' completed the task.')
            ->setBody('<h1>Task completed!</h1><p>User ' . $user->name . ' completed the task.</p>
            <p>Task: ' . $taskTitle . '</p>
            <p>Status: <span style="color: green">done</span>.</p>', 'text/html'); // for HTML rich messages
        });
    }

    return response()->json($task, 200);
});

Route::middleware('auth:airlock')->get('/tasks/{client_id}', function (Request $request, $client_id) {
    \Log::info('Oce se api ruta task: ' . $client_id);
    $author = $request->user()->authors()->first();
    if ($author) {
        $author_id = $request->user()->authors()->first()->user_id;

        // Decrypt crucial values from DB
        $tasks = Task::where('client_id', $client_id)->where('author_id', $author_id)->where('status', 'new')->get();
        foreach ($tasks as $activeTask) {
            if ($activeTask->title) {
                try {
                    $decryptedTitle = Crypt::decryptString($activeTask->title);
                } catch (DecryptException $e) {
                    $decryptedTitle = "Task title was corrupted!";
                }
                $activeTask->title = $decryptedTitle;
            }
            if ($activeTask->description) {
                try {
                    $decryptedDescription = Crypt::decryptString($activeTask->description);
                } catch (DecryptException $e) {
                    $decryptedDescription = "Task description was corrupted!";
                }
                $activeTask->description = $decryptedDescription;
            }
            if ($activeTask->client_notes) {
                try {
                    $decryptedCN = Crypt::decryptString($activeTask->client_notes);
                } catch (DecryptException $e) {
                    $decryptedCN = "Task client notes were corrupted!";
                }
                $activeTask->client_notes = $decryptedCN;
            }
        }
        return $tasks;
    } else {
        // new user no author
        return [];
    }
});

/*Route::get('tasks', function () {

    return Task::all();
});*/

Route::middleware('auth:airlock')->post('/logout', function (Request $request) {
    $request->user()->tokens()->delete();

    return response('Loggedout', 200);
});

Route::post('users', function (Request $request) {
    $request->validate([
        'name' => 'required',
        'email' => 'required|email',
        'password' => 'required',
        'device_name' => 'required'
    ]);

    $user = User::where('email', $request->email)->first();

    \Log::info('Register user: ' . $user);

    if ($user) {
        throw ValidationException::withMessages([
            'email' => ['Email already in use.'],
        ]);
    }

    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
    ]);

    $token = $user->createToken($request->device_name)->plainTextToken;

    $response = [
        'user' => $user,
        'token' => $token,
    ];

    return response($response, 201);
});


Route::post('/airlock/token', function (Request $request) {
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
        'device_name' => 'required'
    ]);

    $user = User::where('email', $request->email)->first();

    if (!$user || !Hash::check($request->password, $user->password)) {
        throw ValidationException::withMessages([
            'email' => ['The provided credentials are incorrect.'],
        ]);
    }

    $token = $user->createToken($request->device_name)->plainTextToken;

    $response = [
        'user' => $user,
        'token' => $token,
    ];

    return response($response, 201);
});
