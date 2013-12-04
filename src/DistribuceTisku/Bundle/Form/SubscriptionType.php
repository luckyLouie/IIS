<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SubscriptionType
 *
 * @author TOM
 */
namespace DistribuceTisku\Bundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class SubscriptionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('denOdberu');
        $builder->add('odberOd');
        $builder->add('odberDo');
        $builder->add('zakaznik');
        $builder->add('titul');
    }

    public function getName()
    {
        return 'subscription';
    }
}