<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Task;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     * NOTE: THIS IS NOT USED!!
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        if (!Auth::user())
        {
            dd('there was problem saying you are not logged in');
            return;
        }

        // check if author logged in
        /*if (!Auth::user()->author)
        {
            dd('there was problem saying you are not author');
            return;
        }*/

        $tasks = Task::where('author_id', Auth::user()->id)->get();

        return view('tasks.index', compact('tasks'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //check if get route has param 'client_id'
        if (request()->has('client_id'))
            $client_id = request()->client_id;

        return view('tasks.create', compact('client_id'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        if (!Auth::user())
        {
            dd('there was problem saying you are not logged in');
            return;
        }

        if (!Auth::user()->author())
        {
            dd('there was problem saying you are not author');
            return;
        }

        $inss = $request->all();
        $inss['status'] = 'new';
        $inss['image'] = '';
        $inss['counter'] = 0;
        $inss['client_notes'] = '';
        $inss['author_id'] = Auth::user()->id;

        // encrypting for extra security
        $inss['description'] = Crypt::encryptString($inss['description']);
        $inss['title'] = Crypt::encryptString($inss['title']);

        // CHECK REPEAT IS INTEGER
        $value = $inss['repeat'];
        $strVal = strval(intval($value));
        $intVal = strval($value);
        if ($strVal != $intVal) {
            $inss['repeat'] = 0;
        }

        $task = Task::create($inss);

        $task->save();

        return redirect('client/' . $inss['client_id']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // find specified task
        $task = Task::findOrFail($id);

        // Decrypt sensitive data from DB
        if ($task['title']) {
            try {
                $decryptedTitle = Crypt::decryptString($task['title']);
            } catch (DecryptException $e) {
                $decryptedTitle = "Task title was corrupted!";
            }
            $task['title'] = $decryptedTitle;
        }
        if ($task['description']) {
            try {
                $decryptedDescription = Crypt::decryptString($task['description']);
            } catch (DecryptException $e) {
                $decryptedDescription = "Task description was corrupted!";
            }
            $task['description'] = $decryptedDescription;
        }

        return view('tasks.show', compact('task'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // not logged in, no editing tasks
        if (!Auth::user())
        {
            dd('there was problem saying you are not logged in');
            return;
        }

        // check if user is author
        if (!Auth::user()->author() && Auth::user()->id != 1)
        {
            dd('there was problem saying you are not author');
            return;
        }

        // find specified task
        $task = Task::findOrFail($id);

        // check if author is editing his task
        if (Auth::user()->id != $task->author_id && Auth::user()->id != 1)
        {
            dd('there was problem saying you are not author of this task');
            return;
        }

        // Decrypt sensitive data from DB
        if ($task['title']) {
            try {
                $decryptedTitle = Crypt::decryptString($task['title']);
            } catch (DecryptException $e) {
                $decryptedTitle = "Task title was corrupted!";
            }
            $task['title'] = $decryptedTitle;
        }
        if ($task['description']) {
            try {
                $decryptedDescription = Crypt::decryptString($task['description']);
            } catch (DecryptException $e) {
                $decryptedDescription = "Task description was corrupted!";
            }
            $task['description'] = $decryptedDescription;
        }
        if ($task['client_notes']) {
            try {
                $decryptedCN = Crypt::decryptString($task['client_notes']);
            } catch (DecryptException $e) {
                $decryptedCN = "Task client notes were corrupted!";
            }
            $task['client_notes'] = $decryptedCN;
        }

        return view('tasks.edit', compact('task'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // not logged in, no updating tasks
        if (!Auth::user())
        {
            dd('there was problem saying you are not logged in');
            return;
        }

        // check if user is author
        if (!Auth::user()->author() && Auth::user()->id != 1)
        {
            dd('there was problem saying you are not author');
            return;
        }

        // find specified task
        $task = Task::findOrFail($id);

        // check if author is updating his task
        if (Auth::user()->id != $task->author_id && Auth::user()->id != 1)
        {
            dd('there was problem saying you are not author of this task');
            return;
        }

        //dd($request->all());

        // CHECK REPEAT IS INTEGER
        $inss = $request->all();
        $value = $inss['repeat'];
        $strVal = strval(intval($value));
        $intVal = strval($value);
        if ($strVal != $intVal) {
            $inss['repeat'] = 0;
        }

        // encrypting for extra security
        $inss['description'] = Crypt::encryptString($inss['description']);
        $inss['title'] = Crypt::encryptString($inss['title']);

        // update it
        $task->update($inss);

        return redirect('client/' . $task->client_id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // not logged in, no deleting tasks
        if (!Auth::user())
            {
                dd('there was problem saying you are not logged in');
                return;
            }

        // check if user is author
        if (!Auth::user()->author() && Auth::user()->id != 1)
            {
                dd('there was problem saying you are not author');
                return;
            }

        // find specified task
        $task = Task::findOrFail($id);

        // check if author created this task or super user
        if (!Auth::user()->author() && Auth::user()->id != 1)
        {
            dd('there was problem saying you are not author of this task');
            return;
        }

        $client_id = $task->client_id;

        $task->delete();

         //log write about deleted task
        \Log::info('Deleting task: ' . $id);

        return redirect('client/' . $client_id);

    }
}
