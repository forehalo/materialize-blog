<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
    {!! Html::style('assets/css/material-icon.css') !!}
    {!! Html::style('assets/css/materialize.min.css', ['media' => 'screen,projection']) !!}
    {!! Html::favicon('assets/image/favicon.ico') !!}
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta name="csrf-token" content="{!! csrf_token() !!}"/>
    <title>Login</title>
    <style>
        html,
        body {
            height: 100%;
        }

        html {
            display: table;
            margin: auto;
        }

        body {
            display: table-cell;
            vertical-align: middle;
        }

        .margin {
            margin: 0 !important;
        }

        .preloader-wrapper {
            height: 20px;
            width: 20px;
            position: fixed;
            right: 5px;
            top: 8px;
        }
    </style>
</head>
<body class="blue">
<div class="login-form col s12 z-depth-4 card-panel">
    <form id="login-form">
        <div class="row">
            <div class="input-field col s12 center">
                <h5 class="center login-form-text">Dashboard</h5>
            </div>
        </div>
        <div class="row margin">
            <div class="input-field col s12">
                <i class="material-icons prefix">account_box</i>
                <input id="log" type="text" name="log">
                <label for="log" class="center-align">Username/email</label>
            </div>
        </div>
        <div class="row margin">
            <div class="input-field col s12">
                <i class="material-icons prefix">lock</i>
                <input id="password" type="password" name="password">
                <label for="password">Password</label>
            </div>
        </div>
        <div class="row">
            <div class="input-field col s12 m12 l12" style="margin-left: -6px !important; margin-top: -6px">
                <input type="checkbox" id="remember-me" class="filled-in" name="remember"/>
                <label for="remember-me">Remember me</label>
            </div>
        </div>
        <div class="row">
            <div class="input-field col s12">
                <button type="submit" class="btn waves-effect waves-light col s12">Login
                    <div class="preloader-wrapper right">
                        <div class="spinner-layer spinner-red-only">
                            <div class="circle-clipper left">
                                <div class="circle"></div>
                            </div>
                            <div class="gap-patch">
                                <div class="circle"></div>
                            </div>
                            <div class="circle-clipper right">
                                <div class="circle"></div>
                            </div>
                        </div>
                    </div>
                </button>
            </div>
        </div>
    </form>
</div>

{!! Html::script('assets/js/jquery-2.1.4.min.js') !!}
{!! Html::script('assets/js/materialize.min.js') !!}
<script>
    $(function () {
        $('#login-form').on('submit', function () {
            $('.preloader-wrapper').addClass('active');

            var token = $('meta[name="csrf-token"]').attr('content');
            var log = $('input[name="log"]').val();
            var pwd = $('input[name="password"]').val();
            var remember = $(':checkbox[name="remember"]').is(':checked');

            $.ajax({
                url: 'login',
                type: 'post',
                data: 'log=' + log + "&password=" + pwd + '&_token=' + token + "&remember=" + remember
            }).done(function (data) {
                $('.preloader-wrapper').removeClass('active');
                if (data.return) {
                    location.assign(data.value);
                } else {
                    Materialize.toast(data.value, 3000);
                }
            }).fail(function () {
                $('.preloader-wrapper').removeClass('active');
                Materialize.toast('Login failed, One more try.', 3000);
            });

            return false;
        });
    });
</script>
</body>
</html>