<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\User;
use App\Task;
use App\Author;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

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

Route::middleware('auth:airlock')->get('/tasks', function (Request $request) {
    return Task::all();
});

Route::middleware('auth:airlock')->get('/dones/{client_id}', function (Request $request, $client_id) {
    \Log::info('Dones se api ruta task: ' . $client_id);
    $author_id = $request->user()->authors()->first()->user_id;
    return Task::where('client_id', $client_id)->where('author_id', $author_id)->where('status', 'done')->get();
});

Route::middleware('auth:airlock')->put('/tasks/{task}',  function (Request $request, Task $task) {
    \Log::info('Oce se api put ruta task: ' . $task->author_id);
    $task->update($request->all());

    $user = User::where('id', $task->client_id)->first();
    $userAuthor = User::where('id', $task->author_id)->first();
    $taskTitle = $request->all()['title'];
    \Log::info('ako je done, saljemo mail authoru: ' . $request->all()['status'] . ' email: ' . $userAuthor->email);
    if ($request->all()['status'] == 'done') {
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
    $author_id = $request->user()->authors()->first()->user_id;
    return Task::where('client_id', $client_id)->where('author_id', $author_id)->where('status', 'new')->get();
});

/*Route::get('tasks', function () {

    return Task::all();
});*/

Route::middleware('auth:airlock')->post('/logout', function (Request $request) {
    $request->user()->tokens()->delete();

    return response('Loggedout', 200);
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
