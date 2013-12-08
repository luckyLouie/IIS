<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace DistribuceTisku\Bundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class CustomerType extends AbstractType
{
    private $suppliers = null;
    private $areas = null;
    function __construct($suppliers = null, $areas = null) {
        $this->suppliers = $suppliers;
        $this->areas = $areas;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('id','hidden');
        $builder->add('jmeno',null,array('label' => '*Jméno:'));
        $builder->add('prijmeni',null,array('label' => '*Příjmení'));
        $builder->add('titul');
        $builder->add('adresa',null,array('label' => '*Adresa'));
        $builder->add('psc', 'choice', array('choices' => $this->areas));
        $builder->add('bankovniSpojeni');
        $builder->add('telefon');
        $builder->add('dodavatel', 'choice', array('choices' => $this->suppliers));
        $builder->add('login',null,array('label' => '*Login'));
       // $builder->add('password');
            $builder->add('password', 'repeated', array(
           'first_name' => 'heslo',
           'second_name' => 'hesloZnovu',
           'type' => 'password'
        ));
    }

    public function getName()
    {
        return 'customer';
    }
}