<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
        <title>Document</title>
    </head>
    <body>
        <h4>你收到了新的回复</h4>
        <p>{{ $data->name }} 在 <a href="{{ url('posts/'.$data->post->slug) }}">《{{ $data->post->title }}》</a> 一文中回复了你：</p>
        <div style="margin: 20px;">
            {!! $data->content !!}
        </div>
        @if($data->parent)
            <p>---------------------------------</p>
            <p>会收到此邮件是因为你在评论时勾选了回复提醒选项。</p>
            <p>拒绝接受请点击 <a href="{{ url('unsubscribe?c='.base64_encode("{$data->parent->name}-{$data->parent->id}")) }}">取消提醒</a></p>
        @endif
    </body>
</html>
