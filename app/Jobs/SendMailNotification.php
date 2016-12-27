<?php

namespace App\Jobs;

use App\Mail\ReplyNotification;
use App\Models\Comment;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class SendMailNotification implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    protected $data;

    /**
     * Create a new job instance.
     *
     * @param Comment $data
     * @param int $parent
     */
    public function __construct(Comment $data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if (! env('APP_ENABLE_MAIL')) {
            return;
        }

        if ($this->data->parent == 0) {
            $address = config('blog.mail');
            $name = config('blog.author');
        } else {
            $this->data->load('parent');
            if (! $this->data->parent->subscription) return;

            $address = $this->data->parent->email;
            $name = $this->data->parent->name;
        }
        $this->data->load('post');

        Mail::to($address, $name)->send(new ReplyNotification($this->data));
    }
}
