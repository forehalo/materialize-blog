@extends('back.template')
@section('title')
    <title>Settings</title>
@stop
@section('main')
    <div class="container">
        <h4>Settings</h4>
        <div class="divider"></div>
        <div class="row">
            <div class="col s12 l6">
                <ul class="tabs">
                    <li class="tab">
                        <a href="#profile" class="active">profile</a>
                    </li>
                    <li class="tab">
                        <a href="#view">View</a>
                    </li>
                    <li class="tab">
                        <a href="#link">Link</a>
                    </li>
                    <li class="tab">
                        <a href="#auth">auth</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="row">
            @include('back.settings.profile')
            @include('back.settings.view')
            @include('back.settings.link')
            @include('back.settings.auth')
        </div>
    </div>
@stop
@section('script')
    <script>
        @if(session('ok'))
            Materialize.toast('{!! session('ok') !!}', 3000);
        @endif
        @if(session('errors'))
            Materialize.toast('Something goes wrong', 3000);
        @endif


        $('.friend-link').on('click', function () {
            var link = $(this);
            var parent = link.parent();
            parent.addClass('active');
            link.slideUp();
            parent.children('form.link-form').slideDown();
        });

        $('.link-form').submit(function () {
            var form = $(this);
            var item = form.parent().children('.friend-link');
            var data = {};
            data._token = form.children('input[name="_token"]').val();
            data.id = form.children('input[name="id"]').val();
            data.name = form.children('input[name="name"]').val();
            data.link = form.children('input[name="link"]').val();

            $.ajax({
                url: 'settings/friend',
                type: 'post',
                data: data
            }).done(function () {
                form.slideUp();
                item.children('span').html(data.name);
                item.children('p').html(data.link);
                item.slideDown().parent().removeClass('active');
                Materialize.toast('Update successfully', 3000);
            }).fail(function () {
                form.slideUp();
                item.slideDown().parent().removeClass('active');
                Materialize.toast('Update failed', 3000);
            });

            return false;
        });

        $('#add-btn').on('click', function(){
            $('#modal').openModal();
        });

    </script>
@stop