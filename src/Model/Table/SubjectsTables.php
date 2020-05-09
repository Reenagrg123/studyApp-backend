<?php

namespace App\Model\Table;

use Cake\ORM\Table;

class SubjectsTables extends Table{

    public function initialize(array $config)
    {

        parent::initialize($config);


        $this->setTable('subject');
        $this->setPrimaryKey('id');
        $this->setDisplayField('c_id');
        $this->addBehavior('Timestamp');


        $this->hasOne('Class',['classname'=>'class_id'])->setForeignKey('id')->setBindingKey([
            'c_id'
        ]);




    }





}

?>