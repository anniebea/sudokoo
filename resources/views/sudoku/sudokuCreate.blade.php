@extends('layouts.app')

@section('additionalHead')
    <script src="{{ asset('js/grid-generation.js') }}" defer></script>
    <script src="{{ asset('js/cell-input.js') }}" defer></script>
    <script src="{{ asset('js/user-input-handling.js') }}" defer></script>
    <script src="{{ asset('js/navigation.js') }}" defer></script>
    <script src="{{ asset('js/live-validation.js') }}" defer></script>
    <script src="{{ asset('js/final-validation.js') }}"></script>
    <script src="{{ asset('js/sudoku-submit-override.js') }}" defer></script>
    <script src="{{ asset('js/windoku-handling.js') }}" defer></script>
    <script src="{{ asset('js/knight-handling.js') }}" defer></script>
@endsection

@section('content')
    <div class="container">
        {{--            Game board--}}
        <form method="POST" id="sudokuForm"
              action="{{ route('sudoku.store', ['user_id' => $user->id]) }}"
        >
            @csrf

            <div class="row">
                {{--            Grid--}}
                <div class="col-lg-6 order-lg-2">
                    <div class="card text-center" id="gridCard">
                        <div class="card-header">
                            <div class="form-group row justify-content-center">
                                <div class="col-md-6">
                                    <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" required value="Sudoku" autocomplete="Sudoku" autofocus>

                                    @error('title')
                                    <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="card-body" id="gridCardBody">
                            <div id="grid" data-mode="editing">
                                    <p id="coordinates">r0c0 / row: 0 column: 0 box: 0</p>
                                {{--                            Grid generated by grid-generation.js--}}
                                <script onload="generate3x3()" src="{{ asset('js/grid-generation.js') }}" defer></script>
                            </div>
                        </div>
                    </div>
                </div>

                {{--            Controls--}}
                <div class="col-lg-3 order-lg-3">
                    <div class="card text-center mx-auto" id="controlCard">
                        <div class="card-header">{{ __('CONTROLS') }}</div>

                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <div class="row justify-content-center">
                                    <button class="btn btn-outline-info m-1" onclick="inputHandler('1')" type="button">1</button>
                                    <button class="btn btn-outline-info m-1" onclick="inputHandler('2')" type="button">2</button>
                                    <button class="btn btn-outline-info m-1" onclick="inputHandler('3')" type="button">3</button>
                                </div>
                                <div class="row justify-content-center">
                                    <button class="btn btn-outline-info m-1" onclick="inputHandler('4')" type="button">4</button>
                                    <button class="btn btn-outline-info m-1" onclick="inputHandler('5')" type="button">5</button>
                                    <button class="btn btn-outline-info m-1" onclick="inputHandler('6')" type="button">6</button>
                                </div>
                                <div class="row justify-content-center">
                                    <button class="btn btn-outline-info m-1" onclick="inputHandler('7')" type="button">7</button>
                                    <button class="btn btn-outline-info m-1" onclick="inputHandler('8')" type="button">8</button>
                                    <button class="btn btn-outline-info m-1" onclick="inputHandler('9')" type="button">9</button>
                                </div>
                                <div class="row justify-content-center">
                                    <button class="btn btn-outline-info m-1" onclick="inputHandler('0')" type="button">0</button>
                                    <button class="btn btn-outline-info m-1" id="backspaceBtn" onclick="inputHandler('Backspace')" type="button"></button>
                                </div>
                            </li>

                            <li class="list-group-item btn-group">
                                <button class="btn btn-outline-dark" id="penBtn" aria-pressed="true" type="button"></button>
                                <button class="btn btn-outline-primary" id="submitBtn" type="submit"></button>
                            </li>
                        </ul>
                    </div>
                </div>

                {{--            Rules--}}
                <div class="col-lg-3 order-lg-1">
                    <div class="card h-100 text-center" id="ruleCard">
                        <div class="card-header">{{ __('RULES') }}</div>
                        <input type="hidden" name="rules" id="ruleInput" value="0">

                        <table class="table table-bordered">
                            @foreach($rules as $rule)
                                @if($rule->name == 'Classic Sudoku')
                                    <tr>
                                        <td class="checkmark" id="{{ str_replace(' ', '', $rule->name) }}Check"></td>
                                        <td>{{ $rule->name }}</td>
                                    </tr>
                                @else
                                    <tr id="Rule{{ $rule->id }}">
                                        <td class="uncheckmark" id="{{ str_replace(' ', '', $rule->name) }}Check"></td>
                                        <td>{{ $rule->name }}</td>
                                    </tr>
                                @endif
                            @endforeach
                            <tr>
                                <td colspan="2">{{ __('Custom rules(Will not be verified by Sudokoo)') }}</td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <textarea id="customRules" name="customRules"></textarea>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
