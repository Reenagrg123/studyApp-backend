<?php

namespace App\Model\Table;

use Cake\ORM\Table;

class CatebooksTables extends Table{

    public function initialize(array $config)
    {

        parent::initialize($config);


        $this->setTable('catebook');
        $this->setPrimaryKey('id');

        $this->hasOne('Category',['classname'=>'id'])->setForeignKey('id')->setBindingKey(['cat_id']);





    }





}

?>