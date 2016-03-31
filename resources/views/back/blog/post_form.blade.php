@extends('back.template')

@section('main')
    <div class="container">
        <h4 class="page-header">Create New Post</h4>
        <div class="divider"></div>
        <div class="card-panel">
            @yield('form-header')
                <div class="row">
                    {!! formText('s10', 'title', 'title', $errors, 'Title','', true, $post->title) !!}
                    {!! formText('s10', 'slug', 'slug', $errors, 'link: http://' . setting('url') . '/posts/', '', true, $post->slug) !!}
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        {!! Form::textarea('summary', old('summary') ? old('summary') : $post->summary, ['id' => 'summary', 'class' => 'materialize-textarea']) !!}
                        <label for="summary">Summary</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        {!! Form::textarea('origin', old('origin') ? old('origin') : $post->origin,['id' => 'content', 'class' => 'materialize-textarea', 'placeholder' => 'markdown syntax']) !!}
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
                    {!! formText('s12 l3', 'category', 'category', $errors, 'Category', '', true, $post->category) !!}
                    {!! formText('s12 l9', 'tags', 'tags', $errors, 'Tags, separated by commas(no space)', '', true, $post->tags) !!}
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <button type="submit" class="btn waves-effect btn-success">Post <i class="material-icons right">send</i></button>
                        <input type="checkbox" id="publish" name="publish" class="filled-in" {!! $post->published ? 'checked' : '' !!}/>
                        <label for="publish">Publish</label>
                    </div>
                </div>
            {!! Form::close() !!}
        </div>
    </div>
@stop

@section('script')
    <script>
        var baseUrl = 'link: http://{!! setting('url') !!}/posts/';

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