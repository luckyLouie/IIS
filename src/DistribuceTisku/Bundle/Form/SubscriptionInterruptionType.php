<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace DistribuceTisku\Bundle\Form;
/**
 * Description of SubscriptionInterruptionType
 *
 * @author TOM
 */
class SubscriptionInterruptionType {
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('od', 'date', array(
    'input'  => 'timestamp',
    'widget' => 'choice',
    'format' => 'yyyy-MM-dd'
));
        $builder->add('do', 'date', array(
    'input'  => 'timestamp',
    'widget' => 'choice',
    'format' => 'yyyy-MM-dd'
));
    }

    public function getName()
    {
        return 'subscriptionInteruption';
    }
}
