@extends('back.template')
@section('title')
    <title>Comments</title>
@stop

@section('main')
    <div class="container">
        <h4 class="page-header">Comments</h4>
        <div class="divider"></div>

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
                        <td>{!! checkbox($comment->valid, ['name' => 'valid', 'value' => $comment->id, 'class' => 'filled-in put-chk']) !!}</td>
                        <td>{!! checkbox($comment->seen, ['name' => 'seen', 'value' => $comment->id, 'class' => 'filled-in put-chk']) !!}</td>
                        <td>
                            {!! Form::open(['method' => 'delete', 'url' => '/comments/' . $comment->id]) !!}
                            {!! destroy('Really destroy this comment?') !!}
                            {!! Form::close() !!}
                        </td>
                    </tr>
                    <tr>
                        <td colspan="6" class="markdown-body">{!! $comment->content !!}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        {!! $links !!}
@stop
@section('script')
   <script>
   @if(session('ok'))
       Materialize.toast('{!! session('ok') !!}', 3000);
   @endif
   </script>
@stop