@extends('layouts.app')
@section('content')
    <h1>Category</h1>
    <div>
        @if(session()->has('success'))
        <div>
            {{session('success')}}
        </div>
        @endif
    </div>
    <div>
        <a href="{{route('category.create')}}" class="create-link">Create</a>
    </div>
    <br>
    <form method="GET" action="{{ route('category.index') }}">
        @csrf
        <input type="text" name="search" placeholder="Search by title"
               value="{{ $filters['searchQuery'] ?? '' }}">
     
        <button type="submit">Apply Filters</button>
    </form>
<br>
    <div>
        <table border="1">
            <tr>
                <th>ID</th>
                <th>Title</th>               
                <!-- <th>UserId</th> -->
                <th>Edit</th>
                <th>Delete</th>

            </tr>
            @foreach($categories as $category)
                <tr>
                    <td>{{$category->id}}</td>
                    <td>{{$category->title}}</td>
                  
                    <!-- <td>{{$category->UserId}}</td> -->
                
                    <td>
                    <a href="{{route('category.edit',['category' => $category])}}" class="create-link">Edit</a>        
                     </td>
                     <td>
                        <form method="post" action="{{route('category.destroy',['category'=> $category])}}">
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