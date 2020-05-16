<?php

namespace App\Model\Table;

use Cake\ORM\Table;

class GenerateexamsTables extends Table{

    public function initialize(array $config)
    {

        parent::initialize($config);


        $this->setTable('generateexam');
        $this->setPrimaryKey('id');
        $this->setDisplayField('c_id');
        $this->addBehavior('Timestamp');


        $this->hasOne('Class')->setForeignKey('id')->setBindingKey([
            'c_id'
        ]);
        $this->hasOne('Subject')->setForeignKey('id')->setBindingKey([
            's_id'
        ]);
        $this->hasOne('Exercises')->setForeignKey('id')->setBindingKey([
            'ex_id'
        ]);


        $this->hasOne('Exam')->setForeignKey('id')->setBindingKey([
            'c_id'
        ]);
        $this->hasOne('Examsubject')->setForeignKey('id')->setBindingKey([
            's_id'
        ]);
        $this->hasOne('Examexercises')->setForeignKey('id')->setBindingKey([
            'ex_id'
        ]);



    }





}

?>