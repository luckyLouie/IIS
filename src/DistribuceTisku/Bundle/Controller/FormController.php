<?php

namespace DistribuceTisku\Bundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use DistribuceTisku\Bundle\Entity\Customer;
use DistribuceTisku\Bundle\Entity\Book;
use DistribuceTisku\Bundle\Entity\Supplier;
use DistribuceTisku\Bundle\Entity\Subscription;
use DistribuceTisku\Bundle\Form\CustomerType;
use DistribuceTisku\Bundle\Form\BookType;
use DistribuceTisku\Bundle\Form\SupplierType;
use DistribuceTisku\Bundle\Form\SubscriptionType;

class FormController extends Controller
{
    
    public function customeraddAction()
    {
        $customer = new Customer();        
        $form = $this->createForm(new CustomerType(), $customer);
        
        $request = $this->getRequest();
        if ($request->getMethod() == 'POST') {
            $form->bind($request);

            if ($form->isValid()) { $c = $request->get("customer");

                $conn = $this->get('database_connection');

                $sql = "INSERT INTO `zakaznik` (`id_zakaznika`, `jmeno`, `prijmeni`, `titul`, `adresa`, `psc`, `bankovni_spojeni`, `kontaktni_udaj`, `id_dodavatele`) VALUES (NULL, '".$c['jmeno']."', '".$c['prijmeni']."', '".$c['titul']."', '".$c['adresa']."', '".$c['psc']."', '".$c['bankovniSpojeni']."', '".$c['telefon']."', '1')";
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                
                $sql = "INSERT INTO `user` (`user_id`, `passwd`, `type`) VALUES ('".$c['login']."', '".$c['password']."', '2')";
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                
                echo "is valid !!";
                $this->get('session')->getFlashBag()->add('vlozeni', 'Nový zákazník byl úspěšně vložen');
                return $this->redirect($this->generateUrl('_customeradd'));
            }
        }
        return $this->render('DistribuceTiskuBundle:Form:customeradd.html.twig', array(
            'form' => $form->createView()
        ));
    }
    
    public function customereditAction()
    {
        $conn = $this->get('database_connection');
        $sql = "SELECT type FROM users WHERE passwd = :pass AND user_id = :user";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue("pass", $user);
        $stmt->bindValue("user", $pass);
        $stmt->execute();
        
    }
    
    public function bookaddAction()
    {
        $book = new Book();
        $form = $this->createForm(new BookType(), $book);
        
        $request = $this->getRequest();
        if ($request->getMethod() == 'POST') {
            $form->bind($request);

            if ($form->isValid()) {
                $conn = $this->get('database_connection');

                $sql = "INSERT INTO `tiskovina` (`ISSN`, `cena`, `titul`, `den_vydani`, `nakladatelstvi`, `vydavatel`) VALUES ('".$c['issn']."', '".$c['titul']."', '".$c['cena']."', '".$c['denVydani']."', '".$c['nakladatelstvi']."', '".$c['vydavatel']."')";
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                
                echo "is valid !!";
                $this->get('session')->getFlashBag()->add('vlozeni', 'Nová tiskovina byla úspěšně vložena');
                return $this->redirect($this->generateUrl('_bookadd'));
            }
        }
        return $this->render('DistribuceTiskuBundle:Form:bookadd.html.twig', array(
            'form' => $form->createView()
        ));
    }
    
    public function bookeditAction()
    {
                
    }
    
    public function supplieraddAction()
    {
        $supplier = new Supplier();
        $form = $this->createForm(new SupplierType(), $supplier);
        
        $request = $this->getRequest();
        if ($request->getMethod() == 'POST') {
            $form->bind($request);

            if ($form->isValid()) {
                
                echo "is valid !!";
                $this->get('session')->getFlashBag()->add('vlozeni', 'Nový dodavatel byl úspěšně vložen');
                return $this->redirect($this->generateUrl('_supplieradd'));
            }
        }
        return $this->render('DistribuceTiskuBundle:Form:supplieradd.html.twig', array(
            'form' => $form->createView()
        ));
    }
    
    public function supliereditAction()
    {
                
    }
    
    public function subscriptionaddAction()
    {
        $subscription = new Subscription();
        $form = $this->createForm(new SubscriptionType(), $subscription);

        $request = $this->getRequest();
        if ($request->getMethod() == 'POST') {
            $form->bind($request);

            if ($form->isValid()) {
                
                echo "is valid !!";
                $this->get('session')->getFlashBag()->add('vlozeni', 'Nový odběr byl úspěšně vložen');
                return $this->redirect($this->generateUrl('_supplieradd'));
            }
        }
        return $this->render('DistribuceTiskuBundle:Form:supplieradd.html.twig', array(
            'form' => $form->createView()
        ));
    }
    
    public function subscriptioneditAction()
    {
                
    }
 
}
