<?php

namespace App\Model\Table;

use Cake\ORM\Table;

class NoticesTables extends Table{

    public function initialize(array $config)
    {

        parent::initialize($config);


        $this->setTable('notice');
        $this->setPrimaryKey('id');





    }





}

?>