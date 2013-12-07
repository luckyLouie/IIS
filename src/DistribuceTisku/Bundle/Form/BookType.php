<?php

namespace DistribuceTisku\Bundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class BookType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('issn',null,array('label' => '*ISSN'));
        $builder->add('titul',null,array('label' => '*Titul'));
        $builder->add('cena',null,array('label' => '*Cena'));
        $builder->add('denVydani');
        $builder->add('nakladatelstvi');
        $builder->add('vydavatel');
    }

    public function getName()
    {
        return 'titul';
    }
}