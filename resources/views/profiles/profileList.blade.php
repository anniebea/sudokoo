@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h1 class="card-title">User list</h1>
                    </div>

                    <ul class="list-group-flush list-group">
                        <li class="list-group-item">
                            <h2>Currently active users</h2>
                            @foreach($users as $user)
                                <div class="card-group">
                                    <div class="card-body">
                                        <ul class="list-group">
                                            <a class="list-group-item list-group-item-primary list-group-item-action"
                                               href="{{ route('user.show', ['id' => $user->id]) }}">
                                                {{ $user->name }}
                                            </a>
                                            <li class="list-group-item">Email: {{ $user->email }}</li>
                                            <li class="list-group-item">Role: {{ $user->role->name }}</li>
                                            <li class="list-group-item btn-group">
                                                <a class="btn btn-primary" href="{{ route('role.edit', ['id' => $user->id]) }}">
                                                    Change role
                                                </a>
                                                <a class="btn btn-danger" href="{{ route('blocking.create', ['id' => $user->id]) }}">
                                                    Block user
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            @endforeach
                        </li>
                        <li class="list-group-item">
                            <h2>Permanently blocked users</h2>
                            @foreach($blocked as $block)
                                <div class="card-group">
                                    <div class="card-body">
                                        <ul class="list-group">
                                            <a class="list-group-item list-group-item-primary list-group-item-action"
                                               href="{{ route('user.show', ['id' => $block->id]) }}">
                                                {{ $block->name }}
                                            </a>
                                            <li class="list-group-item">Email: {{ $block->email }}</li>
                                            <li class="list-group-item">Role: {{ $block->role }}</li>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            @endforeach
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
