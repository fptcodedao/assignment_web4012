<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InfoAdmin extends Mailable
{
    use Queueable, SerializesModels;

    protected $admin, $password;
    /**
     * Create a new message instance.
     *
     * @param $admin
     * @param $password
     */
    public function __construct($admin, $password)
    {
        $this->admin = $admin;
        $this->password = $password;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $admin = $this->admin;
        $password = $this->password;
        return $this->view('admin.mail.account_admin',
            compact('admin', 'password')
        )->subject('Thông tin tài khoản quản trị của bạn');
    }
}
