<?php

namespace App\Model\Table;

use Cake\ORM\Table;

class ExamexercisessTables extends Table{

    public function initialize(array $config)
    {

        parent::initialize($config);


        $this->setTable('examexercises');
        $this->setPrimaryKey('id');
        $this->setDisplayField('id');


        $this->hasOne('Exam',['classname'=>'id'])->setForeignKey('id')->setBindingKey(['c_id']);

        $this->hasOne('Examsubject',['classname'=>'id'])->setForeignKey('id')->setBindingKey(['s_id']);






    }





}

?>