@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        {{ __('Change role for') }} <b>{{ $user->name }}</b>?
                    </div>
                    <div class="card-body">
                        <form action="{{ route('role.update') }}" method="post">
                            @csrf
                            <input type="hidden" name="user_id" value="{{ $user->id }}">

                            <div class="form-group row">
                                <label for="role" class="col-md-4 col-form-label text-md-right">{{ __('Blocking end date') }}:</label>

                                <select id="role" name="role">
                                    @foreach($roles as $role)
                                        <option value="{{ $role->id }}"
                                                @if($role->id == $user->role->id) selected @endif>
                                            {{ $role->name }}
                                        </option>
                                    @endforeach
                                </select>

                                <div class="col-md-6">
                                    @error('role')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Confirm') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
