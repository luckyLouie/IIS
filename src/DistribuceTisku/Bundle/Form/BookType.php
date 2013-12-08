<?php

namespace DistribuceTisku\Bundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class BookType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('issn', null, array('label' => '*ISSN'));
        $builder->add('titul', null, array('label' => '*Titul'));
        $builder->add('cena', null, array('label' => '*Cena'));
        $builder->add('typ', 'choice', array('choices' => array(
        'deník' => 'deník',
        'týdeník' => 'týdeník',
        'měsičník' => 'měsičník',
        'čtvrtletník' => 'čtvrtletník'
        )));
                $builder->add('denVydani', 'choice', array('choices' => array(                        
                        'Pondělí' => 'Pondělí',
                        'Úterý' => 'Úterý',
                        'Středa' => 'Středa',
                        'Čtvrtek' => 'Čtvrtek',
                        'Pátek' => 'Pátek',
                        'Sobota' => 'Sobota',
                        'Neděle' => 'Neděle'
            )));
        $builder->add('nakladatelstvi');
        $builder->add('vydavatel');
    }

    public function getName() {
        return 'titul';
    }

}
