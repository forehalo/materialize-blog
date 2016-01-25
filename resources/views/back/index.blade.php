@extends('back.template')
@section('title')
    <title>个人博客后台管理</title>
@stop

@section('main')
    <div class="container">
        <h4>Dashboard</h4>
        <div class="divider"></div>
        <div class="row white-text dashboard">
            <div class="col s12 m6 l4">
                <div class="card-panel blue">
                    <div class="card-content">
                        <i class="material-icons medium">create</i>
                        <div class="right">
                            <div class="number">2</div>
                            <div>Total Posts</div>
                        </div>
                    </div>
                    <div class="divider"></div>
                    <a href="#">
                        <div class="card-action">
                            <div class="left">View</div>
                            <i class="material-icons right">arrow forward</i>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col s12 m6 l4">
                <div class="card-panel teal">
                    <div class="card-content">
                        <i class="material-icons medium">comment</i>
                        <div class="right">
                            <div class="number">2</div>
                            <div>New Comments</div>
                        </div>
                    </div>
                    <div class="divider"></div>
                    <a href="#">
                        <div class="card-action">
                            <div class="left">View</div>
                            <i class="material-icons right">arrow forward</i>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col s12 m6 l4">
                <div class="card-panel pink">
                    <div class="card-content">
                        <i class="material-icons medium">email</i>
                        <div class="right">
                            <div class="number">2</div>
                            <div>New Messages</div>
                        </div>
                    </div>
                    <div class="divider"></div>
                    <a href="#">
                        <div class="card-action">
                            <div class="left">View</div>
                            <i class="material-icons right">arrow forward</i>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
@stop

