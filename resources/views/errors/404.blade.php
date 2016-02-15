<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
    {!! Html::style('assets/css/materialize.min.css', ['media' => 'screen,projection']) !!}
    {!! Html::favicon('assets/image/favicon.ico') !!}
    <style>
        body {
            background: url('{!! url('assets/image/bg.jpg') !!}') #DFDFDF;
        }
    </style>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <title>404</title>
</head>
<body>
<!-- Modal Structure -->
<div id="modal1" class="modal">
    <div class="container center-align">
    <div class="modal-content">
        {!! Html::image('assets/image/logo-trans.png', null, ['class' => 'responsive-img', 'width' => '400']) !!}
        <h4> 404 </h4>
        <p>The page you are looking for has gone somewhere.</p>
    </div>
    <div class="modal-footer">
        <a class="modal-action modal-close waves-effect waves-green btn-flat" id="back">Back</a>
        <a href="{!! url('/') !!}" class=" modal-action modal-close waves-effect waves-green btn-flat">Home</a>
    </div>
    </div>
</div>

{!! Html::script('assets/js/jquery-2.1.4.min.js') !!}
{!! Html::script('assets/js/materialize.min.js') !!}

<script>
    $('#modal1').openModal({
        dismissible : false
    });
    $('#back').on('click', function(){
        history.back();
    });
</script>
</body>
</html>