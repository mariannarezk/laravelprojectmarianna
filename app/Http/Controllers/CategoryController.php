<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Redirect;
class CategoryController extends Controller
{
    public function index( Request $request){
        $userId = auth()->id();

        // Retrieve tasks associated with the authenticated user
        $categories = Category::where('UserId', $userId);
        if ($request->input('search')) {
            $searchQuery = $request->input('search');
            // Apply search filter to categories
            $categories->where(function($query) use ($searchQuery) {
                $query->where('title', 'like', '%' . $searchQuery . '%');
            });
        }
        
        $categories = $categories->get();
        
        return view('categories.index',['categories'=> $categories]);
    }

    public function create(){
        return view('categories.create');
    }

    public function store(Request $request){
        $data = $request->validate([
             'title'=>'required',
         
        ]);
        
        $userId = auth()->id();

        // Assign the authenticated user's ID to the UserId field
        $data['UserId'] = $userId;
        //save data through model
        $newTask = Category::create($data);

        return redirect(route('category.index'));
    }
    public function edit(Category $category){
        $userId = auth()->id();
        if($category->UserId != $userId){
            return Redirect::back()->with('error', 'You do not have permission to edit this category.');
            // $tasks = Task::all();
        
        }
         return view('categories.edit',['category'=> $category]);
    }
    public function update(Category $category, Request $request){
        $data = $request->validate([
            'title'=>'required',
            
        ]);
        $userId = auth()->id();

        // Assign the authenticated user's ID to the UserId field
        $data['UserId'] = $userId;
        $category->update($data);
        return redirect(route('category.index'))->with('success','category updated Successfully!');
    }

    public function destroy(Category $category){
        $category->delete();
        return redirect(route('category.index'))->with('success','category deleted Successfully!');
    }
}
