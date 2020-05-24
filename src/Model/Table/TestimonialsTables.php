<?php

namespace App\Model\Table;

use Cake\ORM\Table;

class TestimonialsTables extends Table{

    public function initialize(array $config)
    {

        parent::initialize($config);


        $this->setTable('testimonial');
        $this->setPrimaryKey('id');
        $this->setDisplayField('c_id');
        $this->addBehavior('Timestamp');



    }





}

?>