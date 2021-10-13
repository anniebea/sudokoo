@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ $user->name }}</div>
                    <div class="card-body">
                        <div class="list-group">
                            <div class="list-group-item">
                                <p><b>{{ __('E-mail address') }}:</b> {{ $user->email }}</p>
                            </div>
                            <div class="list-group-item">
                                <p><b>{{ __('Birthday') }}:</b> {{ $user->date_of_birth }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
