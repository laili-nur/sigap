<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Email extends MY_Controller
{

    public function index()
    {
        echo "Go to /email/send to test send email";
    }

    public function send()
    {
        // Please specify your Mail Server - Example: mail.yourdomain.com.
        ini_set("SMTP", "sigap.ugmpress@gmail.com");

        // Please specify an SMTP Number 25 and 8889 are valid SMTP Ports.
        ini_set("smtp_port", "25");

        // Please specify the return address to use
        ini_set('sendmail_from', 'sigap.ugmpress@gmail.com');

        $email_config = array(
            'protocol'  => 'smtp',
            'smtp_host' => 'ssl://smtp.googlemail.com',
            'smtp_port' => '465',
            'smtp_user' => getenv('EMAIL_ADDRESS'),
            'smtp_pass' => getenv('EMAIL_PASSWORD'),
            'mailtype'  => 'html',
            'starttls'  => true,
            'newline'   => "\r\n",
        );

        $this->load->library('email', $email_config);
        $this->email->from('sigap.ugmpress@gmail.com', 'SIGAP UGM Press');
        $this->email->to('bgsbla33333@gmail.com');

        $this->email->subject('Kirim dari SIGAP');
        $this->email->message('Isi email dari sigap ugmpress.');

        if ($this->email->send()) {
            echo ('success');
        } else {
            show_error($this->email->print_debugger());
        }
    }
}

/* End of file Email.php */