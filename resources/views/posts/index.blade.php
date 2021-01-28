@extends('layouts.app')

@section('content')
    <div class="container">
        @if(session()->get('success'))
            <div class="alert alert-success">
                {{session()->get('success')}}
            </div>
        @endif
        @if(session()->get('error'))
            <div class="alert alert-danger">
                {{session()->get('error')}}
            </div>
        @endif
        <div class="row align-items-center justify-content-start">
            <h1 class="text-left col">posts</h1><a href="{{route('posts.create')}}" class="btn btn-primary">Hinzufügen</a>
        </div>
        <table class="table table-striped">
            <thead>
            <tr>
                <th>#</th>
                <th>Title</th>
                <th>Name</th>
            </tr>
            </thead>
            <tbody>
            @foreach($posts as $post)
                <tr>
                    <th scope="row">{{$post->id}}</th>
                    <td>{{$post->title}}</td>
                    <td>{{$post->message}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
