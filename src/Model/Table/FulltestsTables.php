<?php

namespace App\Model\Table;

use Cake\ORM\Table;

class FulltestsTables extends Table{

    public function initialize(array $config)
    {

        parent::initialize($config);


        $this->setTable('fulltest');
        $this->setPrimaryKey('id');
        $this->setDisplayField('c_id');
        $this->addBehavior('Timestamp');


        $this->hasOne('Exam',['classname'=>'class_id'])->setForeignKey('id')->setBindingKey([
            'exam_id'
        ]);




    }





}

?>