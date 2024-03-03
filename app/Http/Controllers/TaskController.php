<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\Category;

use Illuminate\Support\Facades\Redirect;
class TaskController extends Controller
{
    //
    public function index(Request $request){
        $userId = auth()->id();
      
        // Retrieve tasks associated with the authenticated user
        $tasks = Task::where('tasks.UserId', $userId);
        $categories = Category::where('UserId', $userId)->get();
        if ($request->input('search')) {
            $searchQuery = $request->input('search');
            $tasks->where(function($query) use ($searchQuery) {
                $query->where('title', 'like', '%' . $searchQuery . '%')
                      ->orWhere('Description', 'like', '%' . $searchQuery . '%');
            });
        }
    
        // Apply category filter
        if ($request->input('category')) {
            $categoryFilter = $request->input('category');
            $tasks->where('CategoryId', $categoryFilter);
        }
    
        // Apply sorting
        if ($request->input('orderby')) {
            $orderBy = $request->input('orderby');
            $tasks->orderBy('DueDate', $orderBy);
        }
    
        $tasks = $tasks->join('categories', 'tasks.CategoryId', '=', 'categories.id')
        ->select('tasks.*', 'categories.title as categoryTitle');
        
   
    
        $tasks = $tasks->get();
    
        return view('tasks.index', compact('tasks', 'categories'));
    }

    public function create(){
        $userId = auth()->id();
        $categories = Category::where('UserId', $userId)->pluck('title', 'id');
        return view('tasks.create', ['categories' => $categories]);
    }

    public function store(Request $request){
        $data = $request->validate([
             'title'=>'required',
             'Description'=>'required',
             'DueDate'=>'required|Date',
         
           
         'CategoryId' => 'required|integer'
        ]);
        
        $userId = auth()->id();

        // Assign the authenticated user's ID to the UserId field
        $data['UserId'] = $userId;
        //save data through model
        $newTask = Task::create($data);

        return redirect(route('task.index'));
    }
    public function edit(Task $task){
        $userId = auth()->id();
 
        $categories = Category::where('UserId', $userId)->pluck('title', 'id');
        if($task->UserId != $userId){
            return Redirect::back()->with('error', 'You do not have permission to edit this task.');
            // $tasks = Task::all();
        
        }
         return view('tasks.edit',['task'=> $task,'categories'=> $categories]);
    }
    public function update(Task $task, Request $request){
        $data = $request->validate([
            'title'=>'required',
            'Description'=>'required',
            'DueDate'=>'required|Date',
        
           
        'CategoryId' => 'required|integer'
        ]);
        $userId = auth()->id();

        // Assign the authenticated user's ID to the UserId field
        $data['UserId'] = $userId;
        $task->update($data);
        return redirect(route('task.index'))->with('success','Task updated Successfully!');
    }

    public function destroy(Task $task){
        $task->delete();
        return redirect(route('task.index'))->with('success','Task deleted Successfully!');
    }
}
