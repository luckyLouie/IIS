<?php
namespace DistribuceTisku\Bundle\Entity;

use Symfony\Component\Validator\Mapping\ClassMetadata;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SubscriptionInterruption
 *
 * @author TOM
 */
class SubscriptionInterruption {
    protected $id;
    protected $od;
    protected $do;
    
    public function getId() {
        return $this->id;
    }

    public function getOd() {
        return $this->od;
    }

    public function getDo() {
        return $this->do;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setOd($od) {
        $this->od = $od;
    }

    public function setDo($do) {
        $this->do = $do;
    }
}
