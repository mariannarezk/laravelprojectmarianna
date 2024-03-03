@extends('layouts.app')
@section('content')
    <h1>Task</h1>
    <div>
        @if(session()->has('success'))
        <div>
            {{session('success')}}
        </div>
        @endif
    </div>
    <div>
        <a href="{{route('task.create')}}" class="create-link">Create</a>
    </div>
<br>
        <form method="GET" action="{{ route('task.index') }}">
        @csrf
        <input type="text" name="search" placeholder="Search by title or description"
               value="{{ $filters['searchQuery'] ?? '' }}">
        <select name="orderby">
            <option value="asc">Sort by Due Date (Ascending)</option>
            <option value="desc">Sort by Due Date (Descending)</option>
        </select>
        <select name="category">
            <option value="">All Categories</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}">{{ $category->title }}</option>
            @endforeach
        </select>
        <button type="submit">Apply Filters</button>
    </form>

<br>

    <div>
        <table border="1">
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Description</th>
                <th>DueDate</th>
                <!-- <th>UserId</th> -->
                <th>CategoryId</th>
                <th>Edit</th>
                <th>Delete</th>

            </tr>
            @foreach($tasks as $task)
                <tr>
                    <td>{{$task->id}}</td>
                    <td>{{$task->title}}</td>
                    <td>{{$task->Description}}</td>
                    <td>{{$task->DueDate}}</td>
                    <!-- <td>{{$task->UserId}}</td> -->
                    <td>{{$task->categoryTitle}}</td>
                    <td>
                    <a href="{{route('task.edit',['task' => $task])}}" class="create-link">Edit</a>        
                     </td>
                     <td>
                        <form method="post" action="{{route('task.destroy',['task'=> $task])}}">
                            @csrf
                            @method('delete')
                            <input type="submit" value="Delete" class="delete-button"/>
                        </form>
                     </td>


                </tr>
            @endforeach
        </table>
    </div>
    @endsection
    @push('styles')
    <link href="{{ asset('css/task.css') }}" rel="stylesheet">
@endpush