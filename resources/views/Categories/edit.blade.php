@extends('layouts.app')
@section('content')
    <h1> Edit a Category </h1>
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
    <form method="post" action="{{route('category.update',['category' => $category])}}" class="create-task-form">
        @csrf
        @method('put')
        <div>
            <label for="title">Title : </label>
            <input type="text" name="title" placeholder="Enter a title" value="{{$category->title}}" class="form-control"/>
        </div>
       
        <div>
            <input type="submit" value="update category" class="btn btn-primary"/>
        </div>
    </form>
@endsection
@push('styles')
    <link href="{{ asset('css/createtask.css') }}" rel="stylesheet">
@endpush