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
        $builder->add('jmeno');
        $builder->add('prijmeni');
        $builder->add('adresa');
        $builder->add('psc');
        $builder->add('telefon');
    }

    public function getName()
    {
        return 'supplier';
    }
}