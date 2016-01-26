@extends('back.template')
@section('title')
    <title>Posts</title>
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
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>laravel5 配合 Queues 使用 Artisan Commands</td>
                    <td>2016-01-26</td>
                    <td><input type="checkbox" id="chk1"/><label for="chk1">NO</label></td>
                    <td><a href="#" class="btn">See</a></td>
                    <td><a href="#" class="btn btn-primary">Edit</a></td>
                    <td><a href="#" class="btn btn-danger">Destroy</a></td>
                </tr>
                <tr>
                    <td>foreach 循环中注意事项</td>
                    <td>2016-01-27</td>
                    <td><input type="checkbox" id="chk2" checked/><label for="chk2">YES</label></td>
                    <td><a href="#" class="btn">See</a></td>
                    <td><a href="#" class="btn btn-primary">Edit</a></td>
                    <td><a href="#" class="btn btn-danger">Destroy</a></td>
                </tr>
                <tr>
                    <td>Excel-Worker 一个 PHP 操作 excel 包</td>
                    <td>2016-01-26</td>
                    <td><input type="checkbox" id="chk3" checked/><label for="chk3">YES</label></td>
                    <td><a href="#" class="btn">See</a></td>
                    <td><a href="#" class="btn btn-primary">Edit</a></td>
                    <td><a href="#" class="btn btn-danger">Destroy</a></td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
@stop