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
                            <ul class="nav nav-tabs nav-fill">
                                <li class="nav-item">
                                    <a class="nav-link active" id="profileInfo-tab" data-toggle="tab" href="#profileInfo" role="tab" aria-controls="profileInfo" aria-selected="true">{{ __('Profile information') }}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="puzzles-tab" data-toggle="tab" href="#puzzles" role="tab" aria-controls="puzzles" aria-selected="false">{{ __('Published puzzles') }}</a>
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
                                <div class="tab-pane" id="puzzles" role="tabpanel" aria-labelledby="puzzles-tab">
                                    <div class="container">
                                        @if(count($puzzles) == 0)
                                            <ul class="list-group">
                                                <div class="list-group-item list-group-item-primary">
                                                    {{ __('You have not published any puzzles!') }}
                                                </div>
                                            </ul>
                                        @else
                                            @foreach($puzzles as $puzzle)
                                                <div class="card-group">
                                                    <div class="card-body">
                                                        <ul class="list-group">
                                                            <a class="list-group-item list-group-item-primary list-group-item-primary"
                                                               href="{{ route('sudoku.show', ['id' => $puzzle->id]) }}">
                                                                {{ $puzzle->title }}
                                                            </a>
                                                            <li class="list-group-item">
                                                                <div>
                                                                    <p>{{ __('Uploaded') }}: {{ date( 'd. M, Y', strtotime($puzzle->created_at)) }}</p>
                                                                    <p>{{ __('Rating') }}: {{ $puzzle->ratingArray[0] }}</p>
                                                                    <p>{{ __('Difficulty rating') }}:
                                                                        {{ $puzzle->difficultyRatingArray[0] }}@if($puzzle->difficultyRatingArray[0] != 'N/A')/5 @endif</p>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif
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
