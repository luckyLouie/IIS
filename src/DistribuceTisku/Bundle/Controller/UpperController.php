<?php

namespace DistribuceTisku\Bundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Description of UpperController
 *
 * @author Marek
 */
class UpperController extends Controller  {
    
    public function timeCheck(){
        $session = $this->getRequest()->getSession();
        if ((time() - $session->get('timeCreated')) > $session->get('expire')) {
            $session->clear();
            // redirect to expired session page
            return 'DistribuceTiskuBundle:Security:login.html.twig';
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
    
}
