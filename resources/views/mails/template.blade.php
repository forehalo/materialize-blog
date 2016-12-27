<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
        <title>Document</title>
    </head>
    <body>
        <h3>{{ trans('app.notification_subject') }}</h3>
        <p>{!!
            trans('app.notification_title', [
                'user' => $data->name,
                'post' => '<a href="'.url('posts/'.$data->post->slug).'"> '.$data->post->title.' </a>'
            ])
        !!}
        <div style="margin: 20px;">
            {!! $data->content !!}
        </div>
        @if($data->parent)
            <p>---------------------------------</p>
            <p>{{ trans('app.notification_reason') }}</p>
            <p>
                <a href="{{ url('unsubscribe?c='.base64_encode("{$data->parent->name}-{$data->parent->id}")) }}">
                    {{ trans('unsubscribe') }}
                </a>
            </p>
        @endif
    </body>
</html>
