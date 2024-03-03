@extends('layouts.app')
@section('content')
    <h1> Create a Category </h1>
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
    <form method="post" action="{{route('category.store')}}" class="create-task-form">
        @csrf
        @method('post')
        <div>
            <label for="title">Title : </label>
            <input type="text" name="title" placeholder="Enter a title" class="form-control"/>
        </div>
       
        <div>
            <input type="submit" value="save a new category" class="btn btn-primary"/>
        </div>
    </form>

@endsection
@push('styles')
    <link href="{{ asset('css/createtask.css') }}" rel="stylesheet">
@endpush