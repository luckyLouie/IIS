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
    
}
