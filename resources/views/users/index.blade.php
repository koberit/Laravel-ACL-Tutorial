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
            <h1 class="text-left col">Users</h1><a href="{{route('users.create')}}" class="btn btn-primary">Hinzufügen</a>
        </div>
        <table class="table table-striped">
            <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>E-Mail</th>
                <th>Permissions</th>
                <th>Groups</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($users as $user)
                <tr>
                    <th scope="row">{{$user->id}}</th>
                    <td>{{$user->name}}</td>
                    <td>{{$user->email}}</td>
                    <td>
                        <ul>
                            @foreach($user->permissions()->get() as $permission)
                                <li>{{$permission->name}}</li>
                            @endforeach
                        </ul>
                    </td>
                    <td>
                        <ul>
                            @foreach($user->groups()->get() as $group)
                                <li>{{$group->name}}</li>
                            @endforeach
                        </ul>
                    </td>
                    <td class="row justify-content-center">
                        <a href="{{route('users.edit', $user->id)}}" class="btn btn-primary">EDIT</a>

                        <form action="{{route('users.destroy', $user->id)}}" method="post">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger ml-3" type="submit" onclick="return confirm('Wollen Sie es wirklich löschen?!')"
                                    style="-webkit-appearance:none;">DELETE</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
