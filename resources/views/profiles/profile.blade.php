@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">{{ $user->name }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="card" style="margin: 1em">
                            <ul class="nav nav-tabs">
                                <li class="nav-item">
                                    <a class="nav-link active" id="profileInfo-tab" data-toggle="tab" href="#profileInfo" role="tab" aria-controls="profileInfo" aria-selected="true">{{ __('Profile information') }}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="publicPuzzles-tab" data-toggle="tab" href="#publicPuzzles" role="tab" aria-controls="publicPuzzles" aria-selected="false">{{ __('Published puzzles') }}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="privatePuzzles-tab" data-toggle="tab" href="#privatePuzzles" role="tab" aria-controls="privatePuzzles" aria-selected="false">{{ __('Private puzzles') }}</a>
                                </li>
                            </ul>

                            <div class="tab-content">
{{--                                Profile information--}}
                                <div class="tab-pane active" id="profileInfo" role="tabpanel" aria-labelledby="profileInfo-tab">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item">
                                            <p><b>{{ __('E-mail address') }}:</b> {{ $user->email }}</p>
                                        </li>
                                        <li class="list-group-item">
                                            <p><b>{{ __('Birthday') }}:</b> {{ $user->date_of_birth }}</p>
                                        </li>
                                        <li class="list-group-item">
                                            <p><b>{{ __('Role') }}:</b> {{ $user->role->name }}</p>
                                        </li>
                                        @if($login == $user->id)
                                            <li class="list-group-item">
                                                <a class="btn btn-primary" href="{{ route('user.edit', ['id' => $user->id]) }}">
                                                    {{ __('Edit profile information') }}
                                                </a>

                                                <a class="btn btn-primary" href="{{ route('password.edit', ['id' => $user->id]) }}">
                                                    {{ __('Change password') }}
                                                </a>
                                            </li>
                                        @endif
                                    </ul>
                                </div>

{{--                                List of published puzzles--}}
                                <div class="tab-pane" id="publicPuzzles" role="tabpanel" aria-labelledby="publicPuzzles-tab">
                                    <div class="container">
                                        <p class="bg-danger">Published puzzles</p>
                                    </div>
                                </div>

{{--                                List of private puzzles--}}
                                <div class="tab-pane" id="privatePuzzles" role="tabpanel" aria-labelledby="privatePuzzles-tab">
                                    <div class="container">
                                        <p class="bg-danger">Private puzzles</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
