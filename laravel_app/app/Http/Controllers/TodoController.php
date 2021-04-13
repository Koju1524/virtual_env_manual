<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request; //class:Request
use App\Todo;  //using todoModel
use Auth;

class TodoController extends Controller
{
    private $todo; //property todoModelClass:instance

    public function __construct(Todo $instanceClass) //Todo instance化
    {
        $this->middleware('auth');
        //dd($this->middleware('auth'));
        $this->todo = $instanceClass; //$this->class = TodoModel class: instance  For Commonality
        //dd($this);
        //dd($instanceClass);  common
    }
    /**
     * Display a listing of the resource.=
     *
     * @return \Illuminate\Http\Response=
     */
    public function index() //DBからの返却dataは、return Object
    {
        $todosList = $this->todo->all(); //get all data return Collection obj allMethod->TodoModel:method
        $todos = $this->todo->getByUserId(Auth::id()); //Auth::id() to get userID login中
        //dd($todos, compact('todos'));
        //dd(compact('todos'));
        return view('todo.index', ['todosList' => $todosList]); //view:function  compact sent invariable to view return:array
    }

    // public function login($userId)
    // {
    //   $currentUserId = DB::table('todos')->where('user_id, id')->first();
    //   $data['user_id']  = $currentUserId;
    //   return View::make('app', $data);
    //   }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('todo.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) //Request $request -> to use request class
    {
        $input = $request->all(); //return associative array key value :request allMethod
        $input['user_id'] = Auth::id();
        //dd($input['user_id']);
        //array:2 [▼
            // "_token" => "zflO2yx"
            // "content" => "jinjinijnjin"
          //]
        //dd($this->todo);
        //dd($this->todo->fill($input));
        $this->todo->fill($input)->save(); //fill: check whether being to able to set argument or not
        //dd($this);
        //dd($input);
        //dd($request);
        return redirect()->to('todo'); //URI
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) //edit($id): get parameter URL
    {
        //dd($todo, $this->todo->find($id));
        $todo = $this->todo->find($id);//find:return collection|model|null => model
        //dd($todo);
        return view('todo.edit', compact('todo')); //return array
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)  //to get info POST FormTag
    {
        $input = $request->all(); //return associative array method & token & content
        //dd($input);
        $this->todo->find($id)->fill($input)->save(); //fill: check whether being to able to set argument or not
        return redirect()->to('todo');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->todo->find($id)->delete();
        return redirect()->to('todo');
    }
}
