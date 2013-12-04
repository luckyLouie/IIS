<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace DistribuceTisku\Bundle\Entity;

use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints as Assert;

class Supplier {
    
    protected $jmeno;
    protected $prijmeni;
    protected $adresa;
    protected $psc;
    protected $telefon;

    public function getJmeno()
    {
        return $this->jmeno;
    }
    
    public function getPrijmeni()
    {
        return $this->prijmeni;
    }
    
    public function getAdresa()
    {
        return $this->adresa;
    }
    
    public function getPsc()
    {
        return $this->psc;
    }
    
    public function getTelefon()
    {
        return $this->telefon;
    }
    
    public function setJmeno()
    {
        $this->jmeno;
    }
    
    public function setPrijmeni()
    {
        $this->prijmeni;
    }
    
    public function setAdresa()
    {
        $this->adresa;
    }
    
    public function setPsc()
    {
        $this->psc;
    }
    
    public function setTelefon()
    {
        $this->telefon;
    }
    
    public static function loadValidatorMetadata(ClassMetadata $metadata){
        $metadata->addPropertyConstraint('jmeno', new NotBlank());
        $metadata->addPropertyConstraint('prijmeni', new NotBlank());
        $metadata->addPropertyConstraint('adresa', new NotBlank());
        $metadata->addPropertyConstraint('psc', new NotBlank());
        
             
       $metadata->addPropertyConstraint('telefon', new Assert\Length(array(
        'min'        => 9,
        'max'        => 9,
        'minMessage' => 'Telefoní číslo musí být ve tvaru XXXXXXXXX',
        'maxMessage' => 'Telefoní číslo musí být ve tvaru XXXXXXXXX',
        )));
    }
}
