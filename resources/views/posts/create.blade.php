@extends('layouts.app')

@section('content')
    <div class="container">
        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{$error}}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="row align-items-center justify-content-start">
            <h1 class="text-left col">Posts hinzufügen</h1>
        </div>
        <form action="{{route('posts.store')}}" method="post">
            @csrf
            <div class="form-group">
                <label for="title" class="col-form-label">Title</label>
                <input class="form-control" type="text" value="{{old('title')}}" id="title" name="title">
            </div>
            <div class="form-group">
                <label for="message" class="col-form-label">Message</label>
                <input class="form-control" type="text" value="{{old('message')}}" id="message" name="message">
            </div>
            <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4">Submit</button>
        </form>
    </div>
@endsection
