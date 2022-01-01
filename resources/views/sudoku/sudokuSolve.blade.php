@extends('layouts.app')

@section('content')
    <div class="container">
        {{--            Game board--}}
        <div class="row justify-content-center content-row">

            {{--            Rules--}}
            <div class="col-lg-3">
                <div class="card h-100 text-center" id="ruleCard">
                    <div class="card-header">{{ __('RULES') }}</div>
                    <table class="table table-bordered">
                        @foreach($rules as $rule)
                            @if($rule->name == 'Classic Sudoku')
                                <tr>
                                    <td class="checkmark"></td>
                                    <td>{{ $rule->name }}</td>
                                </tr>
                            @else
                                @if(in_array($rule->id, $gridRules))
                                    <tr id="Rule{{ $rule->id }}">
                                        <td class="checkmark" id="{{ str_replace(' ', '', $rule->name) }}Checkmark"></td>
                                        <td>{{ $rule->name }}</td>
                                    </tr>
                                @else
                                    <tr id="Rule{{ $rule->id }}">
                                        <td class="uncheckmark" id="{{ str_replace(' ', '', $rule->name) }}Checkmark"></td>
                                        <td>{{ $rule->name }}</td>
                                    </tr>
                                @endif
                            @endif
                        @endforeach
                        <tr class="thead-light">
                            <td colspan="2" class="bg-light">{{ __('Custom rules') }}</td>
                        </tr>
                        <tr>
                            <td colspan="2">{{ $grid->custom_rules }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            {{--            Grid--}}
            <div class="col-lg-6">
                <div class="card h-100 text-center" id="gridCard">
                    <div class="card-header align-items-end">
                        <p> {{ strtoupper($grid->title) }} by {{ $grid->user->name }}</p>
                        <div id="timer"> 0:00:00 </div>
                    </div>

                    <div class="card-body">
                        <p id="coordinates">r0c0 / row: 0 column: 0 box: 0</p>
                        <div id="grid" data-mode="solving">
                            {{--                            Grid generated by grid-generation.js--}}
                        </div>
                    </div>
                </div>
            </div>

            {{--            Controls--}}
            <div class="col-lg-3">
                <div class="card text-center" id="controlCard">
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
                            <button class="btn btn-outline-dark" id="penBtn" aria-pressed="true" type="button" onclick="modeSwitch('pen')"></button>
                            <button class="btn btn-outline-info" id="pencilBtn" aria-pressed="false" type="button" onclick="modeSwitch('pencil')"></button>
                        </li>

                        <li class="list-group-item btn-group">
                            <button class="btn btn-outline-primary" id="finishBtn" type="button" onclick="validatePostFinish()"></button>
                            <button class="btn btn-outline-danger" id="restart" type="button"></button>
                        </li>

                        @if(Auth::id() == $grid->user->id)
                            <li class="list-group-item btn-group">
                                <a class="btn btn-outline-secondary edit" id="editBtn" type="button"
                                href="{{ action('App\Http\Controllers\SudokuController@edit', ['id' => $grid->id]) }}"></a>
                                <a class="btn btn-outline-danger delete" id="deletePuzzle" type="button"
                                href="{{ action('App\Http\Controllers\SudokuController@destroy', ['id' => $grid->id]) }}"></a>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>

            {{--            Modal alert for feedback when finishing puzzle correctly--}}
            <div class="modal" id="successModal" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h2 class="modal-title">{{ __('Congratulations!') }}</h2>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p class="row justify-content-center"> {{ __('Puzzle completed!') }}</p>
                            <p class="row justify-content-center"> {{ __('Final time') }}: <span id="finalTime"></span></p>
                            @if(Auth::check())
                                <form id="RatingForm" method="post"
                                      action="{{ route('rating.store', ['id' => Auth::id()]) }}"
                                >
                                    @csrf
                                    <input type="hidden" id="user" name="user" value="{{ Auth::id() }}">
                                    <input type="hidden" id="grid" name="grid" value="{{ $grid->id }}">

                                    <div class="form-group">
                                        <label for="rating" class="row justify-content-center">{{ __('Did you like the puzzle') }}?</label>
                                        <input type="hidden" id="likeValue" name="rating" value="-1">

                                        <div id="likeRow" class="row justify-content-center">
                                            <span id="like" data-selected="false"></span>

                                            <span id="dislike" data-selected="false"></span>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="difficultyRating" class="row justify-content-center">{{ __('How difficult was the puzzle') }}?</label>
                                        <input type="hidden" id="starValue" name="difficultyRating" value="-1">

                                        <div id="starRow" class="row justify-content-center">
                                            <span id="star1" data-selected="false"></span>
                                            <span id="star2" data-selected="false"></span>
                                            <span id="star3" data-selected="false"></span>
                                            <span id="star4" data-selected="false"></span>
                                            <span id="star5" data-selected="false"></span>
                                        </div>
                                    </div>

                                    <div class="form-group row justify-content-center">
                                        <button type="submit" form="RatingForm" class="btn btn-primary">
                                            {{ __('Submit rating') }}
                                        </button>
                                    </div>
                                </form>
                            @endif
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>

            {{--            Modal alert for feedback when finishing puzzle incorrectly--}}
            <div class="modal" id="failureModal" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">{{ __('Uh, Oh!') }}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p> {{ __('Mistakes have been found!') }}</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{--            Comments and ratings--}}
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header" id="commentCard">{{ __('COMMENTS') }}</div>

                    <div class="card-body">
                        @if(Auth::check())
                            <form id="CommentForm" method="post"
                                  action="{{ route('comment.store', ['id' => Auth::id()]) }}"
                            >
                                @csrf
                                <input type="hidden" id="user" name="user" value="{{ Auth::id() }}">
                                <input type="hidden" id="grid" name="grid" value="{{ $grid->id }}">

                                <div class="form-group row">
                                    <label for="comment" class="col-md-3 col-form-label text-md-right">{{ __('Enter comment') }}:</label>

                                    <div class="col-md-9">
                                        <textarea id="comment" type="text" class="form-control @error('comment') is-invalid @enderror" name="comment"></textarea>

                                        @error('comment')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row justify-content-center">
                                    <button type="submit" form="CommentForm" class="btn btn-primary">
                                        {{ __('Publish comment') }}
                                    </button>
                                </div>
                            </form>
                        @endif
                        <div>
                            @if(count($comments) == 0)
                                <ul class="list-group">
                                    <div class="list-group-item">
                                        {{ __('No comments published yet!') }}
                                    </div>
                                </ul>
                            @else
                                @foreach($comments as $comment)
                                    <div class="card-group">
                                        <div class="card-body">
                                            <ul class="list-group">
                                                <div class="list-group-item">
                                                    <b>
                                                        {{ $comment->user->name }}, {{ date('H:i, d. M, Y', strtotime($comment->created_at)) }}
                                                    </b>
                                                </div>
                                                <li class="list-group-item">
                                                    <p class="commentContent overflow-auto" id="CommentContent{{ $comment->id }}">{{ $comment->content }}</p>
                                                    @if($comment->user_id == Auth::id())
                                                        <form id="CommentUpdate{{ $comment->id }}" method="post" style="display: none"
                                                              action="{{ route('comment.update', ['id' => $comment->id]) }}"
                                                        >
                                                            @csrf
                                                            <input type="hidden" id="user" name="user" value="{{ Auth::id() }}">
                                                            <input type="hidden" id="grid" name="grid" value="{{ $grid->id }}">

                                                            <div class="form-group row">
                                                                <div class="col-md">
                                                                    <textarea id="commentUpdate" type="text" class="form-control @error('commentUpdate') is-invalid @enderror" name="commentUpdate">{{ $comment->content }}</textarea>

                                                                    @error('commentUpdate')
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                    </span>
                                                                    @enderror
                                                                </div>
                                                            </div>

                                                            <div class="form-group row justify-content-center">
                                                                <div class="btn-group">
                                                                    <button type="submit" form="CommentUpdate{{ $comment->id }}" class="btn btn-primary">
                                                                        {{ __('Publish edit') }}
                                                                    </button>
                                                                    <button type="button" class="btn btn-secondary" id="CommentCancel{{ $comment->id }}">
                                                                        {{ __('Cancel') }}
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </form>

                                                        <div class="commentBtns">
                                                            <span class="edit" id="editComment{{ $comment->id }}"></span>
                                                            <a href="{{ route('comment.destroy', ['id' => $comment->id]) }}" class="delete" id="delete{{ $comment->id }}"></a>
                                                        </div>
                                                    @elseif(Auth::check())
                                                        <div class="reportButton">
                                                            <a href="{{ route('comment.report', ['id' => $comment->id]) }}" class="report" id="reportComment{{ $comment->id }}"></a>
                                                        </div>
                                                    @endif
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

            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">{{ __('RATINGS') }}</div>

                    <div class="card-body">
                        <details>
{{--                            number_format($avgRating*100,2)--}}
                            <summary>{{ __('Overall rating') }}: {{ $avgRating }}</summary>
                            <ul>
                                <li>{{ __('Your rating') }}: {{ $userRating }}</li>
                            </ul>
                        </details>

                        <details>
                            <summary>{{ __('Difficulty rating') }}: {{ $avgDifficultyRating }}</summary>
                            <ul>
                                <li>{{ __('Your rating') }}: {{ $userDifficultyRating }}</li>
                                <li>{{ __('Author\'s rating') }}: {{ $authorDifficultyRating }}</li>
                            </ul>
                        </details>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script onload="generate3x3({{ $contents }})" src="{{ asset('js/grid-generation.js') }}" defer></script>
@endsection
