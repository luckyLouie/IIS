<?php
namespace DistribuceTisku\Bundle\Entity;

use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints as Assert;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Book
 *
 * @author TOM
 */
class Book {
    protected $issn;
    protected $titul;
    protected $cena;
    protected $denVydani;
    protected $nakladatelstvi;
    protected $vydavatel;
    
    public function getIssn() {
        return $this->issn;
    }

    public function getTitul() {
        return $this->titul;
    }

    public function getCena() {
        return $this->cena;
    }

    public function getDenVydani() {
        return $this->denVydani;
    }

    public function getNakladatelstvi() {
        return $this->nakladatelstvi;
    }

    public function getVydavatel() {
        return $this->vydavatel;
    }

    public function setIssn($issn) {
        $this->issn = $issn;
    }

    public function setTitul($titul) {
        $this->titul = $titul;
    }

    public function setCena($cena) {
        $this->cena = $cena;
    }

    public function setDenVydani($denVydani) {
        $this->denVydani = $denVydani;
    }

    public function setNakladatelstvi($nakladatelstvi) {
        $this->nakladatelstvi = $nakladatelstvi;
    }

    public function setVydavatel($vydavatel) {
        $this->vydavatel = $vydavatel;
    }
    
    public static function loadValidatorMetadata(ClassMetadata $metadata){
        $metadata->addPropertyConstraint('issn', new NotBlank());
        $metadata->addPropertyConstraint('titul', new NotBlank());
        $metadata->addPropertyConstraint('cena', new NotBlank());
        $metadata->addPropertyConstraint('denVydani', new NotBlank());
        $metadata->addPropertyConstraint('nakladatelstvi', new NotBlank());
        $metadata->addPropertyConstraint('vydavatel', new NotBlank());
    }

}
