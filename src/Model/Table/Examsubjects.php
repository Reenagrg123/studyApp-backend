<?php

namespace App\Model\Table;

use Cake\ORM\Table;

class Examsubjects extends Table{

    public function initialize(array $config)
    {

        parent::initialize($config);


        $this->setTable('examsubject');
        $this->setPrimaryKey('id');
        $this->setDisplayField('c_id');
        $this->addBehavior('Timestamp');


        $this->hasOne('Exam',['classname'=>'class_id'])->setForeignKey('id')->setBindingKey([
            'c_id'
        ]);




    }





}

?>