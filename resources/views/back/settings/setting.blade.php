@extends('back.template')
@section('title')
    <title>Settings</title>
@stop
@section('main')
    <div class="container">
        <h4>Settings</h4>
        <div class="divider"></div>
        <div class="row">
            <div class="col s12 m12 l6">
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
                </ul>
            </div>
        </div>
        @include('back.settings.profile')
        @include('back.settings.view')
        @include('back.settings.link')
    </div>
@stop
@section('script')
    <script>
        @if(session('ok'))
            Materialize.toast('{!! session('ok') !!}', 3000);
        @endif
    </script>
@stop