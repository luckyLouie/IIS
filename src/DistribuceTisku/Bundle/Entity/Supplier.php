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
    
    protected $login;
    protected $password;
    protected $jmeno;
    protected $prijmeni;
    protected $adresa;
    protected $psc;
    protected $telefon;

    public function getLogin() {
        return $this->login;
    }

    public function getPassword() {
        return $this->password;
    }

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
    
    public function setLogin($login) {
        $this->login = $login;
    }

    public function setPassword($password) {
        $this->password = $password;
    }
   
    public function setJmeno($jmeno) {
        $this->jmeno = $jmeno;
    }

    public function setPrijmeni($prijmeni) {
        $this->prijmeni = $prijmeni;
    }

    public function setAdresa($adresa) {
        $this->adresa = $adresa;
    }

    public function setPsc($psc) {
        $this->psc = $psc;
    }

    public function setTelefon($telefon) {
        $this->telefon = $telefon;
    }


    
}
