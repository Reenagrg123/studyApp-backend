<?php

namespace App\Model\Table;

use Cake\ORM\Table;

class UsersTables extends Table{


    public function initialize(array $config)
    {

        $this->setTable('user');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');


        $this->hasOne('Class',['classname'=>'class_id'])->setForeignKey('id')->setBindingKey([
            'class'
        ]);




    }



}

?>