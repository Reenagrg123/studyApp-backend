<?php

namespace App\Controller\Services;

use App\Controller\AppController;
use Cake\Network\Email\Email;
use Cake\Routing\Router;
use Cake\Mailer;


class EmailService extends AppController{
    public $base_url;

    public function initialize(){
        parent::initialize();
        $this->viewBuilder()->layout("adminlayout");
        $this->base_url=Router::url("/",true);

    }

public function send(){
    Mailer\TransportFactory::setConfig('default', [
        'className' => 'Mail'
    ]);

// Sample SMTP configuration.
    Mailer\TransportFactory::setConfig('gmail', [
        'host' => 'ssl://smtp.gmail.com',
        'port' => 465,
        'username' => 'my@gmail.com',
        'password' => 'secret',
        'className' => 'Smtp'
    ]);
}

    public function sendmail(){

        $email = new Email('default');
        $email->from(['kumarshubhendu228@gmail.com' => 'My Site'])
            ->to('kumarshubhendu228@gmail.com')
            ->subject('About')
            ->send('My message');






        var_dump("Asdasd");exit;


    }


}


?>