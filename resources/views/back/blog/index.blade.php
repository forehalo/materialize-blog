@extends('back.template')
@section('title')
    <title>Posts</title>
    <style>
        .pagination li.active {
            background-color: #448AFF !important;
        }
    </style>
@stop

@section('main')
    <div class="container">
        <h4 class="page-header">Post<a class="btn-floating btn-large waves-effect waves-light blue right"><i
                        class="material-icons">mode_edit</i></a></h4>
        <div class="divider"></div>

        <div class="col l12">
            <table class="bordered striped">
                <thead>
                <tr>
                    <th>Title</th>
                    <th>Date</th>
                    <th>Published</th>
                    <th>Operation</th>
                </tr>
                </thead>
                <tbody>
                @foreach($posts as $post)
                    <tr>
                        <td>{!! $post->title !!}</td>
                        <td>{!! substr($post->created_at, 0, 10) !!}</td>
                        <td>{!! publishedCheckbox($post) !!}</td>
                        <td><a href="{!! url('/posts/' . $post->slug) !!}" class="btn btn-success">See</a></td>
                        <td><a href="{!! url('/posts/' . $post->id . '/edit') !!}" class="btn btn-warning">Edit</a></td>
                        <td>
                            {!! Form::open(['method' => 'delete', 'url' => '/posts/' . $post->id]) !!}
                            <button type="submit" class="btn btn-danger">Destroy</button>
                            {!! Form::close() !!}
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        {!! $links !!}
    </div>
@stop

@section('script')
    <script>
        $(function(){
           $(document).on('change', ':checkbox', function(){
               var id = $(this).attr('id').substr(3);
               var self = $(this);
               var label = self.parent().children('label');
               var token = $('input[name="_token"]').val();

               self.hide();
               label.hide();
               self.parent().append('<i class="material-icons mi-refresh">refresh</i>');

               $.ajax({
                   url: '/posts/' + id + '/publish',
                   type: 'put',
                   data: '_token=' + token + '&published=' + this.checked
               }).done(function(){
                   $('.mi-refresh').remove();
                   self.show();
                   label.html(label.html() == 'NO' ? 'YES' : 'NO').show();
               }).fail(function(){
                   $('.mi-refresh').remove();
                   self.show().prop('checked', self.is(':checked') ? null : 'checked');
                   label.show();
                   Materialize.toast('Toggle failed', 3000);
               });
           });
        });
    </script>
    @stop