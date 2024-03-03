@extends('layouts.app')
@section('content')
    <h1> Create a Task </h1>
    <div>
        @if($errors->any())
        <ul>
            @foreach($errors->all() as $error)
                <li>{{$error}}
                </li>
            @endforeach

        </ul>
        @endif
</div>
    <form method="post" action="{{route('task.store')}}" class="create-task-form">
        @csrf
        @method('post')
        <div>
            <label for="title">Title : </label>
            <input type="text" name="title" placeholder="Enter a title"  class="form-control"/>
        </div>
        <div>
            <label for="description">Description : </label>
            <input type="text" name="Description" placeholder="Enter a description"  class="form-control"/>
        </div>
        <div>
            <label for="duedate">Due Date : </label>
            <input type="date" name="DueDate"  class="form-control"/>
        </div>
        <!-- <div>
            <label for="userid">user id : </label>
            <input type="number" name="UserId" />
        </div> -->
        <!-- <div>
            <label for="categoryid">category id : </label>
            <input type="number" name="CategoryId" />
        </div> -->
        <div>
    <label for="categoryid">Category:</label>
    <select name="CategoryId"  class="form-control">
        @foreach($categories as $categoryId => $categoryTitle)
            <option value="{{ $categoryId }}">{{ $categoryTitle }}</option>
        @endforeach
    </select>
</div>

        <div>
            <input type="submit" value="save a new task" class="btn btn-primary"/>
        </div>
    </form>

@endsection

@push('styles')
    <link href="{{ asset('css/createtask.css') }}" rel="stylesheet">
@endpush