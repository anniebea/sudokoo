@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h3>Sudoku list</h3>
                        <a href="{{ url('/sudokoo/create/sudoku') }}" class="btn btn-primary">Create Sudoku</a>
                    </div>

                    <div class="card-body">
{{--                        single sudoku card--}}
                        @if(count($grids) == 0)
                            <ul class="list-group">
                                <a class="list-group-item list-group-item-primary list-group-item-primary" href="#">
                                    {{ __('No puzzles published yet!') }}
                                </a>
                            </ul>
                        @else
                            @foreach($grids as $grid)
                                <ul class="list-group">
                                    <a class="list-group-item list-group-item-primary list-group-item-primary"
                                       href="{{ route('sudoku.show', ['id' => $grid->id]) }}">
                                        {{ $grid->title }}
                                    </a>
                                    <li class="list-group-item">
                                        <div>
                                            <p>Author: {{ $grid->user->name }}</p>
                                            <p>Uploaded: {{ $grid->created_at->format('d. M, Y') }}</p>
                                            <p>Rating: coming soon</p>
{{--                                            92%--}}
                                            <p>Difficulty rating: coming soon</p>
{{--                                            4/5--}}
                                        </div>
                                    </li>
                                </ul>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
