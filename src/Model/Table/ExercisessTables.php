<?php

namespace App\Model\Table;

use Cake\ORM\Table;

class ExercisessTables extends Table{

    public function initialize(array $config)
    {

        parent::initialize($config);


        $this->setTable('exercises');
        $this->setPrimaryKey('id');
        $this->setDisplayField('id');


        $this->hasOne('Class',['classname'=>'id'])->setForeignKey('id');
        $this->hasOne('Subject',['classname'=>'id'])->setForeignKey('id');






    }





}

?>