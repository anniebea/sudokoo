@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">User list</h5>
                    </div>

                    <div class="card-body">

{{--                    single user card--}}
                        @foreach($users as $user)
                            <div class="card-group">
                                <div class="card-body">
                                    <ul class="list-group">
                                        <a class="list-group-item list-group-item-primary list-group-item-action"
                                           href="{{ route('user.show', ['id' => $user->id]) }}"> {{ $user->name }}</a>
                                        <li class="list-group-item">Email: {{ $user->email }}</li>
                                        <li class="list-group-item">Role: {{ $user->role->name }}</li>
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
