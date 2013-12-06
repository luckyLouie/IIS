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

    protected $uzivatel;
    protected $denOdberu;
    protected $odberOd;
    protected $odberDo;
    protected $zakaznik;
    protected $titul;
    protected $issn;
    protected $id;

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }
    
    public function getUzivatel() {
        return $this->uzivatel;
    }

    public function getIssn() {
        return $this->issn;
    }
    
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

    public function setUzivatel($uzivatel) {
        $this->uzivatel = $uzivatel;
    }

    public function setIssn($issn) {
        $this->issn = $issn;
    }

    public function setDenOdberu($denOdberu) {
        $this->denOdberu = $denOdberu;
    }

    public function setOdberOd($odberOd) {
        $this->odberOd = $odberOd;
    }

    public function setOdberDo($odberDo) {
        $this->odberDo = $odberDo;
    }

    public function setZakaznik($zakaznik) {
        $this->zakaznik = $zakaznik;
    }

    public function setTitul($titul) {
        $this->titul = $titul;
    }
}
