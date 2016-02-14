@extends('back.template')

@section('main')
    <div class="container">
        <h4 class="page-header">Create New Post</h4>
        <div class="divider"></div>
        <div class="card-panel">
            @yield('form-header')
                <div class="row">
                    <div class="input-field col s10">
                        {!! Form::text('title', old('title'),['id' => 'title', 'class' => 'validate']) !!}
                        <label for="title">Title</label>
                    </div>
                    <div class="input-field col s10">
                        {!! Form::text('slug', old('slug'), ['id' => 'slug', 'class' => 'validate']) !!}
                        <label for="slug">link: http://{!! config('blog.url') !!}/posts/</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        {!! Form::textarea('summary', old('summary'), ['id' => 'summary', 'class' => 'materialize-textarea']) !!}
                        <label for="summary">Summary</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        {!! Form::textarea('origin', old('origin'),['id' => 'content', 'class' => 'materialize-textarea', 'placeholder' => 'markdown syntax']) !!}
                        <label for="content">Content
                            <a href="javascript:void(0)" class="btn btn-floating btn-success tooltipped btn-preview" data-position="right" data-delay="0" data-tooltip="preview" style="width: 20px;height: 20px">
                                <i class="material-icons right" style="line-height: 20px;font-size: 15px">visibility</i>
                            </a>
                        </label>
                    </div>
                    <div id="preview-modal" class="modal">
                        <div class="modal-content markdown-body"></div>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12 m12 l3">
                        {!! Form::text('category', old('category'),['id' => 'category', 'class' => 'validate']) !!}
                        <label for="category">Category</label>
                    </div>
                    <div class="input-field col s12 m12 l9">
                        {!! Form::text('tags', old('tags'), ['id' => 'tags', 'class' => 'validate']) !!}
                        <label for="tags">Tags, separated by commas(no space)</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <button type="submit" class="btn waves-effect btn-success">Post <i class="material-icons right">send</i></button>
                        <input type="checkbox" id="publish" name="publish" class="filled-in"/>
                        <label for="publish">Publish</label>
                    </div>
                </div>
            {!! Form::close() !!}
        </div>
    </div>
@stop

@section('script')
    <script>
        var baseUrl = 'link: http://{!! config('blog.url') !!}/posts/';

        $(function () {
            $(document).on('keyup', '#slug', function () {
                $('label[for="slug"]').html(baseUrl + $(this).val());
            });

            $('.btn-preview').on('click', function(){
                var content = marked($('#content').val());
                var body = $('.markdown-body');

                body.children().remove();
                body.append(content);
                Prism.highlightAll();
                $('#preview-modal').openModal();
            });
        });
    </script>
@stop