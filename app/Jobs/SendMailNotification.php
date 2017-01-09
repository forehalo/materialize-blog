<?php

namespace App\Jobs;

use App\Mail\ReplyNotification;
use Setting;
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
        // parent comment
        $parent = $this->data->parent;
        if (is_null($parent)) {
            $mail = Setting::get('email');
            // Ensure receiver email configured.
            if (!$mail) return;
            $address = $mail;
            $name = Setting::get('author');
        } else {
            // Ensure parent comment subscript reply notification.
            if (! $parent->subscription) return;

            $address = $parent->email;
            $name = $parent->name;
        }

        Mail::to($address, $name)->send(new ReplyNotification($this->data));
    }
}
