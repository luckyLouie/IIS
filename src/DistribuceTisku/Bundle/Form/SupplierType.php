<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace DistribuceTisku\Bundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class SupplierType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('jmeno',null,array('label' => '*Jméno:'));
        $builder->add('prijmeni',null,array('label' => '*Příjmení'));
        $builder->add('adresa',null,array('label' => '*Adresa:'));
        $builder->add('psc',null,array('label' => '*Psč:'));
        $builder->add('telefon');
        $builder->add('login',null,array('label' => '*Login:'));
            $builder->add('password', 'repeated', array(
           'first_name' => 'heslo',
           'second_name' => 'hesloZnovu',
           'type' => 'password'
        ));
    }

    public function getName()
    {
        return 'supplier';
    }
}