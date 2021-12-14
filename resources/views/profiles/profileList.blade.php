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
                            <h2>Temporarily blocked users</h2>
                            @foreach($blockedUsers as $blocked)
                                <div class="card-group">
                                    <div class="card-body">
                                        <ul class="list-group">
                                            <a class="list-group-item list-group-item-primary list-group-item-action"
                                               href="{{ route('user.show', ['id' => $blocked->id]) }}">
                                                {{ $blocked->name }}
                                            </a>
                                            <li class="list-group-item">Email: {{ $blocked->email }}</li>
                                            <li class="list-group-item">Role: {{ $blocked->role }}</li>
                                            <li class="list-group-item">Blocked until: {{ date('d. M, Y.', strtotime($blocked->date_to)) }}
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            @endforeach
                        </li>
                        <li class="list-group-item">
                            <h2>Permanently blocked users</h2>
                            @foreach($permanentlyBlocked as $permanent)
                                <div class="card-group">
                                    <div class="card-body">
                                        <ul class="list-group">
                                            <a class="list-group-item list-group-item-primary list-group-item-action"
                                               href="{{ route('user.show', ['id' => $permanent->id]) }}">
                                                {{ $permanent->name }}
                                            </a>
                                            <li class="list-group-item">Email: {{ $permanent->email }}</li>
                                            <li class="list-group-item">Role: {{ $permanent->role }}</li>
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
