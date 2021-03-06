<?php

// src/Acme/SecurityBundle/Controller/SecurityController.php;
namespace DistribuceTisku\Bundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\HttpFoundation\Session\Session;

class SecurityController extends Controller
{    
    public function loginAction()
    {
        return$this->render('DistribuceTiskuBundle:Security:login.html.twig');
    }
    
    public function login_checkAction()
    {
        $request = $this->getRequest();
        $user = $request->get("_username");
        $pass = $request->get("_password");
        $type = "";
        
        $conn = $this->get('database_connection');
        $sql = "SELECT type, person_id FROM users WHERE passwd = '".$pass."' AND user_id = '".$user."'";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        
        foreach($stmt as $one){
            $type = $one["type"];
            $id = $one["person_id"];
        }
        
        if($type != ""){
		    $session = $this->getRequest()->getSession();
			if(!isset($session))
				$session = new Session();
            $session->start();
            $session->set('user', $user);
            $session->set('type', $type);
            $session->set('id', $id);
            $session->set('timeCreated', time());
            $session->set('expire', 3600);
             $this->get('session')->getFlashBag()->add('ok', 'Přihlášení proběhlo úspěšně');
            return $this->render('DistribuceTiskuBundle:Page:index.html.twig');
        }else{
            $this->get('session')->getFlashBag()->add('exception', 'Špatné uživatelské jméno nebo heslo');
            return $this->render('DistribuceTiskuBundle:Security:login.html.twig');
        }
    }
    
    public function logoutAction()
    {
        $session = $this->getRequest()->getSession();
        $session->clear();
        $this->get('session')->getFlashBag()->add('ok', 'Odhlášení proběhlo úspěšně');
        return$this->render('DistribuceTiskuBundle:Security:logout.html.twig');
    }
}
