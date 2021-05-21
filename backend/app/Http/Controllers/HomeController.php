<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Author;
use App\Task;
use App\User;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $author = Author::where('user_id', Auth::user()->id)->first();
        if ($author) {
            $clients = $author->users->all();
        } else {
            $clients = [];
        }
        //$tasks = Task::where('author_id', Auth::user()->id)->get();
        return view('home', compact('clients'));
    }

    /**
     * Show the client view.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function showClient($id)
    {
        $client = User::firstWhere('id', $id);
        $tasks = Task::where('author_id', Auth::user()->id)->where('client_id', $id)->get();
        return view('client', compact('client', 'tasks'));
    }

    /**
     * Show the client create view.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function showClientCreate()
    {
        return view('client_create');
    }

    /**
     * Add the client to Author (if exists).
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function addClient(Request $request)
    {
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

        
        //dd($request->input('email'));

        $client = User::where('email', $request->input('email'))->first();

        if (!$client) {
            return 'Provided email \'' . $request->input('email') . '\' was not found in out database.';
        }

        $author = Auth::user()->author();

        $client->authors()->attach($author);
        
        //log write about created connection
        \Log::info('Client connected to author: ');

        return redirect('home');
    }

    /**
     * Remove the client from Author (if exists and added).
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function removeClient(Request $request)
    {
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

        //dd($request->input('email'));
        if (request()->has('client_id'))
            $client = User::where('id', request()->client_id)->first();

        if (!$client) {
            return 'Unexpected error #23234. Client not found.';
        }

        $author = Auth::user()->author();

        $client->authors()->detach($author);
        
        //log write about created connection
        \Log::info('Client disconnected from author: ');

        return redirect('home');
    }
}
