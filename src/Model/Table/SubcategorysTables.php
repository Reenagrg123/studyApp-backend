<?php

namespace App\Model\Table;

use Cake\ORM\Table;

class SubcategorysTables extends Table{

    public function initialize(array $config)
    {

        parent::initialize($config);


        $this->setTable('subcategory');
        $this->setPrimaryKey('id');
        $this->setDisplayField('c_id');
        $this->addBehavior('Timestamp');


        $this->hasOne('Category',['classname'=>'class_id'])->setForeignKey('id')->setBindingKey([
            'cat_id'
        ]);



    }





}

?>