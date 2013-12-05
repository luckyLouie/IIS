<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace DistribuceTisku\Bundle\Entity;

class Customer {
    
    protected $id;
    protected $login;
    protected $password;
    protected $jmeno;
    protected $prijmeni;
    protected $titul;
    protected $adresa;
    protected $psc;
    protected $bankovniSpojeni;
    protected $telefon;

    public function getLogin()
    {
        return $this->login;
    }
    
    public function getPassword()
    {
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
    
    public function getTitul()
    {
        return $this->titul;
    }
    
    public function getAdresa()
    {
        return $this->adresa;
    }
    
    public function getPsc()
    {
        return $this->psc;
    }
    
      public function getId()
    {
        return $this->id;
    }
    
    public function getBankovniSpojeni()
    {
        return $this->bankovniSpojeni;
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

    public function setTitul($titul) {
        $this->titul = $titul;
    }

    public function setAdresa($adresa) {
        $this->adresa = $adresa;
    }

    public function setPsc($psc) {
        $this->psc = $psc;
    }

    public function setBankovniSpojeni($bankovniSpojeni) {
        $this->bankovniSpojeni = $bankovniSpojeni;
    }

    public function setTelefon($telefon) {
        $this->telefon = $telefon;
    }
    public function setId($id) {
        $this->id= $id;
    }
       

}
