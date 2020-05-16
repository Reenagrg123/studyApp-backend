<?php

namespace App\Model\Table;

use Cake\ORM\Table;

class MaterialsTables extends Table{

    public function initialize(array $config)
    {

        parent::initialize($config);


        $this->setTable('material');
        $this->setPrimaryKey('id');
        $this->setDisplayField('id');


        $this->hasOne('Class',['classname'=>'id'])->setForeignKey('id')->setBindingKey(['c_id']);

        $this->hasOne('Subject',['classname'=>'id'])->setForeignKey('id')->setBindingKey(['s_id']);


        $this->hasOne('Exam',['classname'=>'id'])->setForeignKey('id')->setBindingKey(['c_id']);

        $this->hasOne('Examsubject',['classname'=>'id'])->setForeignKey('id')->setBindingKey(['s_id']);




    }





}

?>