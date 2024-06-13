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
        'task' => 'required|min:5',
        'subtask1' => 'nullable|string',
        'subtask2' => 'nullable|string',
        'subtask3' => 'nullable|string',
    ]);

    $data = [
        'user' => Auth::user()->name,
        'task' => $request->input('task'),
        'subtask1' => $request->input('subtask1'),
        'subtask2' => $request->input('subtask2'),
        'subtask3' => $request->input('subtask3'),
    ];

    Todo::create($data);

    return redirect()->route('todo')->with('success', 'Aktivitas disimpan!');
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
          'task' => 'required|min:5',
          "is_done" => 'nullable'
        ]);
        
        $data = [
        'task' => $request->input('task'),
        ];
        
        if ($request->filled('is_done')) {
        $data['is_done'] = $request->input('is_done');
        }
        
        Todo::where('id', $id)->update($data);
        return redirect()->route('todo')->with('success', 'perubahan data disimpan!');
    }
    
    public function updateSubtask(Request $request, string $id)
    {
        $request->validate([
            'subtask1' => 'nullable|string',
            'subtask2' => 'nullable|string',
            'subtask3' => 'nullable|string',
            'is_subtask1_done' => 'nullable|boolean',
            'is_subtask2_done' => 'nullable|boolean',
            'is_subtask3_done' => 'nullable|boolean'
        ]);
    
        $data = [];
    
        foreach (['subtask1', 'subtask2', 'subtask3'] as $subtask) {
            if ($request->has($subtask)) {
                $data[$subtask] = $request->input($subtask);
            }
            if ($request->has('is_' . $subtask . '_done')) {
                $data['is_' . $subtask . '_done'] = $request->input('is_' . $subtask . '_done');
            }
        }
    
        Todo::where('id', $id)->update($data);
    
        // Check if all relevant subtasks are done
        $todo = Todo::findOrFail($id);
        $isDone = true; // Assume true initially
    
        // Check each subtask if it exists and is done
        foreach (['subtask1', 'subtask2', 'subtask3'] as $subtask) {
            if ($todo->$subtask && !$todo->{'is_' . $subtask . '_done'}) {
                $isDone = false; // If any relevant subtask is not done, set isDone to false
                break; // No need to check further
            }
        }
    
        // Update is_done based on the result
        $todo->is_done = $isDone ? 1 : 0;
        $todo->save();
    
        return redirect()->route('todo')->with('success', 'Perubahan data disimpan!');
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
