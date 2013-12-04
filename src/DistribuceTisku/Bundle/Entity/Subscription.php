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

class Subscription {
    
    protected $denOdberu;
    protected $odberOd;
    protected $odberDo;
    protected $zakaznik;
    protected $titul;

    public function getDenOdberu()
    {
        return $this->denOdberu;
    }
    
    public function getOdberOd()
    {
        return $this->odberOd;
    }
    
    public function getOdberDo()
    {
        return $this->odberDo;
    }
    
    public function getZakaznik()
    {
        return $this->zakaznik;
    }
    
    public function getTitul()
    {
        return $this->titul;
    }
    
    public function setDenOdberu()
    {
        $this->denOdberu;
    }
    
    public function setOdberOd()
    {
        $this->odberOd;
    }
    
    public function setOdberDo()
    {
        $this->odberDo;
    }
    
    public function setZakaznik()
    {
        $this->zakaznik;
    }
    
    public function setTitul()
    {
        $this->titul;
    }
    
    public static function loadValidatorMetadata(ClassMetadata $metadata){
        $metadata->addPropertyConstraint('denOdberu', new NotBlank());
        $metadata->addPropertyConstraint('odberOd', new NotBlank());
        $metadata->addPropertyConstraint('odberDo', new NotBlank());
        $metadata->addPropertyConstraint('zakaznik', new NotBlank());
        $metadata->addPropertyConstraint('titul', new NotBlank());
    }
}
