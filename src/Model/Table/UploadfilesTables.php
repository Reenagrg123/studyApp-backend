<?php

namespace App\Model\Table;

use Cake\ORM\Table;

class UploadfilesTables extends Table{

    public function initialize(array $config)
    {

        parent::initialize($config);


        $this->setTable('uploadfile');
        $this->setPrimaryKey('id');

        $this->hasOne('Class')->setForeignKey('id')->setBindingKey([
            'c_id'
        ]);
        $this->hasOne('Subject')->setForeignKey('id')->setBindingKey([
            's_id'
        ]);
        $this->hasOne('Exercises')->setForeignKey('id')->setBindingKey([
            'ex_id'
        ]);


    }





}

?>