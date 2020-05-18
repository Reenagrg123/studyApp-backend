<?php

namespace App\Controller;

use App\Controller\AppController;

class EbookController extends AppController{

    public function initialize()
    {
        parent::initialize();
        $this->viewBuilder()->layout("adminlayout");

        $this->set("title","Dashboard");
    }

        public function index(){




    }

    public function category(){



    }


}


?>