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
            <h1 class="text-left col">Group editieren</h1>
        </div>
        <form action="{{route('groups.update', $group->id)}}" method="post">
            @csrf
            @method('PATCH')
            <div class="form-group">
                <label for="name" class="col-form-label">Name</label>
                <input class="form-control" type="text" value="{{$group->name}}" id="name" name="name">
            </div>
            <div class="form-group">
                <label for="slug" class="col-form-label">Slug</label>
                <input class="form-control" type="text" value="{{$group->slug}}" id="slug" name="slug">
            </div>
            <div class="form-group">
                <label for="description" class="col-form-label">Description</label>
                <input class="form-control" type="text" value="{{$group->description}}" id="description" name="description">
            </div>
            <div class="from-group">
                <label for="permissions" class="col-form-label">Permissions</label>
                @foreach($permissions as $permission)
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="{{$permission->name}}" name="permissions[]" value="{{$permission->id}}"
                               @if($group->hasPermission($permission->id)) checked @endif>
                        <label class="custom-control-label" for="{{$permission->name}}">{{$permission->name}}</label>
                    </div>
                @endforeach
            </div>
            <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4">Submit</button>
        </form>
    </div>
@endsection
