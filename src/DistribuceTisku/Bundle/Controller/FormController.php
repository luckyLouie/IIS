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
    
    public function bookAddAction()
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
        return $this->render('DistribuceTiskuBundle:Form:bookAdd.html.twig', array(
            'form' => $form->createView()
        ));
    }
    
    public function bookEditAction()
    {
                
    }
    
    public function supplierAddAction()
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
        return $this->render('DistribuceTiskuBundle:Form:supplierAdd.html.twig', array(
            'form' => $form->createView()
        ));
    }
    
    public function suplierEditAction()
    {
                
    }
    
    public function subscriptionAddAction()
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
        return $this->render('DistribuceTiskuBundle:Form:supplierAdd.html.twig', array(
            'form' => $form->createView()
        ));
    }
    
    public function subscriptionEditAction()
    {
                
    }
 
}
