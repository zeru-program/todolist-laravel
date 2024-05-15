<?php

namespace App\Http\Controllers\Todo;


use App\Models\User;
use App\Models\Todo;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $max_page = 10;
        
        if (Auth::user()) {
            
         $userAuth = Auth::user()->name;
         
        if (request('search')) {
        $data = Todo::where('user', $userAuth)->where('task', 'like', '%' .request('search'). '%')->paginate($max_page);
     //   $auth = User::orderBy('name', 'asc')->get();
        } else {
        $data = Todo::where('user', $userAuth)->orderBy('task', 'asc')->paginate($max_page);
    //    $auth = User::orderBy('name', 'asc')->get();
          }
        return view('todo.home', ['data' => $data]);
        } else {
        $new = 'Untuk mengakses aplikasi, silakan login terlebih dahulu.';
        return view('todo.home', ['newbie' => $new]);
       }
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
          'task' => 'required|min:5'
        ]);
        
        $data = [
        'user' => Auth::user()->name,
        'task' => $request->input('task')
        ];
        
        Todo::create($data);
        return redirect()->route('todo')->with('success', 'aktifitas disimpan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
          'task' => 'required|min:5'
        ]);
        
        $data = [
        'task' => $request->input('task'),
        'is_done' => $request->input('is_done')
        ];
        
        Todo::where('id', $id)->update($data);
        return redirect()->route('todo')->with('success', 'perubahan data disimpan!');
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Todo::where('id', $id)->delete();
        return redirect()->route('todo')->with('success', 'berhasil menghapus data!');
    }
}
