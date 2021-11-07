@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">User list</h5>
                    </div>
{{--                    single user card--}}
                    <div class="card-body">
                        @foreach($users as $user)
                            <div class="card-group">
                                <div class="card-body">
                                    <ul class="list-group">
                                        <a class="list-group-item list-group-item-primary list-group-item-action"
                                           href="{{ route('user.show', ['id' => $user->id]) }}">
                                            @if($user->is_blocked)
                                                <b>BLOCKED</b>
                                            @endif
                                                {{ $user->name }}
                                        </a>
                                        <li class="list-group-item">Email: {{ $user->email }}</li>
                                        <li class="list-group-item">Role: {{ $user->role->name }}</li>
                                        @if($user->is_blocked == false)
                                        <li class="list-group-item btn-group">
                                            <a class="btn btn-primary" href="#">Change role</a>
                                            <a class="btn btn-danger" href="{{ route('blocking.create', ['id' => $user->id]) }}">
                                                Block user
                                            </a>
                                        </li>
                                        @endif
                                    </ul>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
