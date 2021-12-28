@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h1 class="card-title">Reported comment list</h1>
                    </div>

                    <ul class="list-group-flush list-group">
                        <li class="list-group-item">
                            <h2>Reported comments</h2>
                            @if(count($reported) == 0)
                                <div class="card-group">
                                    <div class="card-body">
                                        <ul class="list-group">
                                            <li class="list-group-item list-group-item-primary">{{ __('No comments to show!') }}</li>
                                        </ul>
                                    </div>
                                </div>
                            @else
                                @foreach($reported as $comment)
                                    <div class="card-group">
                                        <div class="card-body">
                                            <ul class="list-group">
                                                <li class="list-group-item list-group-item-primary">
                                                    {{ $comment->user->name }}, {{ date('H:i, d. M, Y', strtotime($comment->created_at)) }}
                                                </li>
                                                <li class="list-group-item">{{ $comment->content }}</li>
                                                <li class="list-group-item btn-group">
                                                    <a class="btn btn-danger" type="button"
                                                       href="{{ route('comment.destroy', ['id' => $comment->id]) }}">
                                                        Remove comment
                                                    </a>
                                                    <a class="btn btn-secondary" type="button"
                                                       href="{{ route('report.remove', ['id' => $comment->id]) }}">
                                                        Remove report
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </li>
                        <li class="list-group-item">
                            <h2>Previously reported comments</h2>
                            @if(count($prevReported) == 0)
                                <div class="card-group">
                                    <div class="card-body">
                                        <ul class="list-group">
                                            <li class="list-group-item list-group-item-primary">{{ __('No comments to show!') }}</li>
                                        </ul>
                                    </div>
                                </div>
                            @else
                                @foreach($prevReported as $comment)
                                    <div class="card-group">
                                        <div class="card-body">
                                            <ul class="list-group">
                                                <li class="list-group-item list-group-item-secondary">
                                                    {{ $comment->user->name }}, {{ date('H:i, d. M, Y', strtotime($comment->created_at)) }}
                                                </li>
                                                <li class="list-group-item">{{ $comment->content }}</li>
                                            </ul>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
