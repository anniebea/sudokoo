@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <p>Sudoku list</p>
                        <a href="{{ url('/sudokoo/create/sudoku') }}" class="btn btn-primary float-right">Create Sudoku</a>
                    </div>

                    <div class="card-body">
{{--                        single sudoku card--}}
                        <ul class="list-group">
                            <a class="list-group-item list-group-item-primary list-group-item-action">Sudoku Nr.1</a>
                            <li class="list-group-item">
                                <div>
                                    <p>Author: admin</p>
                                    <p>Uploaded: 03.X, 2021</p>
                                    <p>Rating: 92%</p>
                                    <p>Difficulty rating:2/5</p>
                                </div>
                            </li>
                        </ul>
                        <ul class="list-group">
                            <a class="list-group-item list-group-item-primary list-group-item-action">Sudoku Nr.2</a>
                            <li class="list-group-item">
                                <div>
                                    <p>Author: admin</p>
                                    <p>Uploaded: 03.X, 2021</p>
                                    <p>Rating: 92%</p>
                                    <p>Difficulty rating:2/5</p>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
