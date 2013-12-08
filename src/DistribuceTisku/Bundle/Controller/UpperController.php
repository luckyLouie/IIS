<?php

namespace DistribuceTisku\Bundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Description of UpperController
 *
 * @author Marek
 */
class UpperController extends Controller {

    public function timeCheck($requiredUserType = null) {
        $session = $this->getRequest()->getSession();
        if ((time() - $session->get('timeCreated')) > $session->get('expire')) {
            $session->clear();
            // redirect to expired session page
            return 'DistribuceTiskuBundle:Security:login.html.twig';
        }
        if ($requiredUserType == null) {           
            if ((int)$session->get('type') > 0){
                if((int)$session->get('type') != $requiredUserType){
            return 'DistribuceTiskuBundle:Page:index.html.twig';}}
        }
        //return "";
    }

    function customerNameToId($name) {
        $conn = $this->get('database_connection');
        $sql = "SELECT * FROM zakaznik z JOIN users u ON z.id_zakaznika=u.person_id  WHERE u.user_id='" . $name . "';";
        $users = $conn->fetchAll($sql);
        foreach ($users as $user) {
            return $user['id_zakaznika'];
        }
    }

    function supplierNameToId($name) {
        $conn = $this->get('database_connection');
        $sql = "SELECT * FROM dodavatel z JOIN users u ON z.id_dodavatele=u.person_id  WHERE u.user_id='" . $name . "';";
        $users = $conn->fetchAll($sql);
        foreach ($users as $user) {
            return $user['id_dodavatele'];
        }
    }    
    
    function getSuppliers() {
        $conn = $this->get('database_connection');
        $uzivatele = $conn->fetchAll('SELECT `jmeno`,`prijmeni`, `id_dodavatele` FROM `dodavatel`');

        foreach ($uzivatele as $one) {
            $uzivatel[$one['id_dodavatele']] = $one['prijmeni'] ." ". $one['jmeno'];
        }
        return $uzivatel;
    }

        function getAreas() {
        $conn = $this->get('database_connection');
        $uzivatele = $conn->fetchAll('SELECT * FROM `oblast` ORDER BY id_oblast');

        foreach ($uzivatele as $one) {
            $uzivatel[$one['id_oblast']] = $one['psc'] ." , ". $one['nazev']." , ". $one['posta'];
        }
        return $uzivatel;
    }
    
}
