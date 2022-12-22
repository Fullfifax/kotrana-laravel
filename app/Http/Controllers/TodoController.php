<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TodoController extends Controller
{
    // To store all users
    public $users;

    public function __construct() 
    {
        $this->users = User::getAllUsers();
    }

    /**
     * Assign a to do to an user
     * 
     * @param App\Todo $todo
     * @param App\User $user
     * @return \Illuminate\Http\Response
     */
    public function affectedTo(Todo $todo, User $user)
    {
        $todo->affectedTo_id = $user->id;
        $todo->affectedBy_id = Auth::user()->id;
        $todo->update();

        return back();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // To store user connected
        $userId = Auth::user()->id;
        $datas = Todo::where(['affectedTo_id' => $userId])->orderBy('id', 'desc')->paginate(5);

        /*
        $datas = Todo::all()->reject(function ($todo) {
            return $todo->done == 0;
        });
        */
        $users = $this->users;

        return view('todos.index', compact('datas', 'users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('todos.create');
    }

    /**
     * Display a listing of undone's todos
     */
    public function undone()
    {
        $datas = Todo::where('done', 0)->paginate(5);
        $users = $this->users;
        return view('todos.index', compact('datas', 'users'));
    }

    /**
     * Display a listing of done's todos
     */
    public function done()
    {
        $datas = Todo::where('done', 1)->paginate(5);
        $users = $this->users;
        return view('todos.index', compact('datas', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $todo = new Todo();
        $todo->creator_id = Auth::user()->id;
        $todo->affectedTo_id = Auth::user()->id;
        $todo->name = $request->name;
        $todo->description = $request->description;

        // Save to database
        $todo->save();

        // Flash notification
        notify()->success("Todo #$todo->id added successfully :)");

        return redirect()->route('todos.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function edit(Todo $todo)
    {
        return view('todos.edit', compact('todo'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Todo $todo)
    {
        if(!isset($request->done)) {
            $request['done'] = 0;
        }
        $todo->update($request->all());

        notify()->success("Todo #$todo->id udpated successfully :)");

        return redirect()->route('todos.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Todo  $todo
     * @return void
     */
    public function destroy(Todo $todo)
    {
        $todo->delete();

        notify()->error("Todo #$todo->id deleted successfully :)");
        
        return back();
    }

    /**
     * Make done todo
     * 
     * @param Todo $todo
     * @return void
     */
    public function makeDone(Todo $todo) {
        $todo->done = 1;
        $todo->update();
        
        return back();
    }

    /**
     * Make undone todo
     * 
     * @param Todo $todo
     * @return void
     */
    public function makeUndone(Todo $todo) {
        $todo->done = 0;
        $todo->update();

        return back();
    }
}
