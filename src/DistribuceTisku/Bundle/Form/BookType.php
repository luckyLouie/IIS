<?php

namespace DistribuceTisku\Bundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class BookType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('issn');
        $builder->add('titul');
        $builder->add('cena');
        $builder->add('denVydani');
        $builder->add('nakladatelstvi');
        $builder->add('vydavatel');
    }

    public function getName()
    {
        return 'titul';
    }
}