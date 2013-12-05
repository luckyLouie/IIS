<?php

namespace DistribuceTisku\Bundle\Controller;

use DistribuceTisku\Bundle\Entity\Customer;
use DistribuceTisku\Bundle\Form\CustomerType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CustomerController extends Controller
{
    
    public function customerAddAction()
    {
        $customer = new Customer();        
        $form = $this->createForm(new CustomerType(), $customer);
        
        $request = $this->getRequest();
        if ($request->getMethod() == 'POST') {
            $form->bind($request);

            if ($form->isValid()) { 
                $c = $request->get("customer");

                $conn = $this->get('database_connection');

                $sql = "INSERT INTO `zakaznik` (`id_zakaznika`, `jmeno`, `prijmeni`, `titul`, `adresa`, `psc`, `bankovni_spojeni`, `kontaktni_udaj`, `id_dodavatele`) VALUES (NULL, '".$c['jmeno']."', '".$c['prijmeni']."', '".$c['titul']."', '".$c['adresa']."', '".$c['psc']."', '".$c['bankovniSpojeni']."', '".$c['telefon']."', '1')";
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                
                $sql = "SELECT `id_zakaznika` FROM `zakaznik` WHERE `jmeno` = '".$c['jmeno']."' AND `prijmeni` = '".$c['prijmeni']."' AND `adresa` = '".$c['adresa']."' LIMIT 1";
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                
                foreach($stmt as $type){
                    $id = $type["id_zakaznika"];
                }
        
                $sql = "INSERT INTO `users` (`user_id`, `passwd`, `type`, `person_id`) VALUES ('".$c['login']."', '".$c['password']."', '2', '".$id."')";
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                
                $this->get('session')->getFlashBag()->add('vlozeni', 'Nový zákazník byl úspěšně vložen');
                return $this->redirect($this->generateUrl('_customerAdd'));
            }
        }
        return $this->render('DistribuceTiskuBundle:Form:customerAdd.html.twig', array(
            'form' => $form->createView()
        ));
    }
    
    public function customerEditAction()
    {
        $customer = new Customer();       
        $form = $this->createForm(new CustomerType(), $customer);
        $user = $this->getRequest()->getSession()->get("user");
              
        $request = $this->getRequest();
        if ($request->getMethod() == 'POST') {

        }
        return $this->render('DistribuceTiskuBundle:Form:customerAdd.html.twig', array(
            'form' => $form->createView()
        ));
        
    }
   
    public function customerRemoveAction()
    {
        $conn = $this->get('database_connection');
        $sql = "SELECT type FROM users WHERE passwd = :pass AND user_id = :user";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue("pass", $user);
        $stmt->bindValue("user", $pass);
        $stmt->execute();
        
    } 
}
