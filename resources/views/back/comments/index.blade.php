@extends('back.template')
@section('title')
    <title>Comments</title>
@stop

@section('main')
    <div class="container">
        <h4 class="page-header">Comments</h4>
        <div class="divider"></div>

        <div class="col s12">
            <div class="row">
                <div class="col s12">
                    <div class="card-panel">
                        <table class="bordered striped">
                            <thead>
                            <tr>
                                <th>Author</th>
                                <th>Date</th>
                                <th>Post</th>
                                <th>Valid</th>
                                <th>Seen</th>
                                <th>Operation</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($comments as $comment)
                                <tr>
                                    <td>{!! $comment->name !!}</td>
                                    <td>{!! substr($comment->created_at, 0, 10) !!}</td>
                                    <td>{!! $comment->post->title !!}</td>
                                    <td>{!! checkbox($comment->valid, ['name' => 'valid', 'value' => $comment->id, 'class' => 'filled-in']) !!}</td>
                                    <td>{!! checkbox($comment->seen, ['name' => 'seen', 'value' => $comment->id, 'class' => 'filled-in']) !!}</td>
                                    <td>
                                        {!! Form::open(['method' => 'delete', 'url' => '/comments/' . $comment->id]) !!}
                                        <button type="submit" class="btn btn-danger">Destroy</button>
                                        {!! Form::close() !!}
                                    </td>
                                </tr>
                                <tr><td colspan="6">{!! $comment->content !!}</td></tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            {!! $links !!}
        </div>
    </div>
@stop