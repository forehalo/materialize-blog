@extends('back.template')
@section('title')
    <title>Upload</title>
@stop

@section('main')
    <div class="container">
        <h4 class="page-header">Upload</h4>
        <div class="divider"></div>

        <div class="card-panel">
        	<p>Still using simple, inefficient forms to post your exciting articles? </p>
            <p>Come on, try uploading files or parsing files from CLI which just need you to write them in given format!</p>
                Write articles the way you like.
        	<h6 class="red-text">HERE IT COMES!!!</h6>
            {!! Html::Image('http://7xr4kb.com1.z0.glb.clouddn.com/format.png', 'format', ['class' => 'materialboxed']) !!}
            <p>Note:</p>
            <blockquote>
                <ul>
                    <li>1. One line, one item</li>
                    <li>2. Give it a space after each item's colon</li>
                    <li>3. Separate tags with comma(no space)</li>
                    <li>4. 'Publish' or nothing on the Penultimate line to specify whether it accessible immediately</li>
                    <li>5. Finish header with '---'(three minuses) on the last line</li>
                    <li>6. Updating instead of creating if slug exists</li>
                </ul>
            </blockquote>
            <h5>1. Upload</h5>
            <div class="row">
                {!! Form::open(['method' => 'post', 'url' => url('/posts/upload'), 'id' => 'upload-form', 'files' => 'true']) !!}
                    <div class="file-field input-field  col s12 l8">
                        <div class="btn">
                            <span>File</span>
                            <input type="file" name="upload-file">
                        </div>
                        <div class="file-path-wrapper">
                            <input class="file-path validate" type="text">
                        </div>
                    </div>
                {!! Form::close() !!}
            </div>
            <h5>2. CLI</h5>
            <div class="row">
                <p>Use CLI to post articles, you should put your .md files to the storage path('storage/app/posts/') through FTP or any other way first. </p>
                <pre>
    $ php artisan post:one filename //Post one
    $ php artisan post:all          //Post all .md in storage dir
                </pre>
            </div>
        </div>
    </div>
@stop

@section('script')
    <script>
        @if(session('ok'))
            Materialize.toast('{!! session('ok') !!}', 3000);
        @endif
        @if(session('errors'))
            Materialize.toast('Something goes wrong!!!', 3000);
        @endif

        $('input[name="upload-file"]').on('change', function(){
            $('#upload-form').submit();
        });
    </script>
@stop