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
                $c = $request->get("titul");
                $conn = $this->get('database_connection');

                $sql = "INSERT INTO `tiskovina` (`ISSN`, `cena`, `titul`, `den_vydani`, `nakladatelstvi`, `vydavatel`) VALUES ('".$c['issn']."', '".$c['titul']."', '".$c['cena']."', '".$c['denVydani']."', '".$c['nakladatelstvi']."', '".$c['vydavatel']."')";
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                
                echo "is valid !!";
                $this->get('session')->getFlashBag()->add('vlozeni', 'Nová tiskovina byla úspěšně vložena');
                return $this->redirect($this->generateUrl('_bookAdd'));
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
                $c = $request->get("supplier");
                
                $conn = $this->get('database_connection');

                $sql = "INSERT INTO `dodavatel` (`jmeno`, `prijmeni`, `adresa`, `psc`, `kontaktni_udaj`) VALUES ('".$c['jmeno']."', '".$c['prijmeni']."', '".$c['adresa']."', '".$c['psc']."', '".$c['telefon']."')";
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                
                $sql = "SELECT `id_dodavatele` FROM `dodavatel` WHERE `jmeno` = '".$c['jmeno']."' AND `prijmeni` = '".$c['prijmeni']."' AND `adresa` = '".$c['adresa']."' LIMIT 1";
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                
                foreach($stmt as $type){
                    $id = $type["id_dodavatele"];
                }
        
                $sql = "INSERT INTO `users` (`user_id`, `passwd`, `type`, `person_id`) VALUES ('".$c['login']."', '".$c['password']."', '1', '".$id."')";
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                
                echo "is valid !!";
                $this->get('session')->getFlashBag()->add('vlozeni', 'Nový dodavatel byl úspěšně vložen');
                return $this->redirect($this->generateUrl('_supplierAdd'));
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
        
        $conn = $this->get('database_connection');
        $uzivatele = $conn->fetchAll('SELECT `jmeno`, `id_zakaznika` FROM `zakaznik`');

        foreach ($uzivatele as $one){
            $uzivatel[$one['id_zakaznika']] = $one['jmeno'];
        }
        
        $uzivatele = $conn->fetchAll('SELECT `ISSN`, `titul` FROM `tiskovina`');

        foreach ($uzivatele as $one){
            $titul[$one['ISSN']] = $one['titul'];
        }
        
        $form = $this->createFormBuilder($subscription)
            ->add('uzivatel', 'choice',  array('choices' => $uzivatel))
            ->add('denOdberu', 'choice',  array('choices' => array(
                'Neděle' => 'Neděle',
                'Pondělí' => 'Pondělí',
                'Úterý' => 'Úterý',
                'Středa' => 'Středa',
                'Čtvrtek' => 'Čtvrtek',
                'Pátek' => 'Pátek',
                'Sobota' => 'Sobota'
                )))
            ->add('odberOd', 'date', array(
    'input'  => 'timestamp',
    'widget' => 'choice',
    'format' => 'yyyy-MM-dd'
))
            ->add('odberDo', 'date', array(
    'input'  => 'timestamp',
    'widget' => 'choice',
    'format' => 'yyyy-MM-dd'
))
            ->add('titul', 'choice',  array('choices' => $titul))
            ->getForm();
        
        $request = $this->getRequest();
        $form->handleRequest($request);  
        
            if ($form->isValid()) {
                $c = $request->get("form");
                echo $c['odberOd']['year'];
                //$conn = $this->get('database_connection');
                
                $sql = "INSERT INTO `odber` (`den_odberu`, `odber_od`, `odber_do`, `id_zakaznika`, `ISSN`) VALUES ('".$c['denOdberu']."', '".$c['odberOd']['year']."-".$c['odberOd']['month']."-".$c['odberOd']['day']."', '".$c['odberDo']['year']."-".$c['odberDo']['month']."-".$c['odberDo']['day']."', '".$c['uzivatel']."', '".$c['titul']."')";
                $stmt = $conn->prepare($sql);
                $stmt->execute();

                echo "is valid !!";
                $this->get('session')->getFlashBag()->add('vlozeni', 'Nový odběr byl úspěšně vložen');
                return $this->redirect($this->generateUrl('_subscriptionAdd'));
            }
        
        return $this->render('DistribuceTiskuBundle:Form:subscriptionAdd.html.twig', array(
            'form' => $form->createView()
        ));
    }

    public function subscriptionEditAction()
    {
        $request = $this->getRequest();
        if ($request->getMethod() == 'POST') {

        }

        $conn = $this->get('database_connection');
        $sql = "SELECT `odber`.`id_odberu`, `odber`.`den_odberu`,`odber`.`odber_od`,`odber`.`odber_do`,`odber`.`id_platby`,`zakaznik`.`jmeno`,`zakaznik`.`prijmeni`,`tiskovina`.`titul`  FROM `odber`";
        $sql = $sql."JOIN `zakaznik` ON `odber`.`id_zakaznika` = `zakaznik`.`id_zakaznika`";
        $sql = $sql."JOIN `tiskovina` ON `odber`.`ISSN` = `tiskovina`.`ISSN` ORDER BY `odber`.`id_odberu`";
        $odbery = $conn->prepare($sql);
        $odbery->execute();
        return $this->render('DistribuceTiskuBundle:Form:subscriptionList.html.twig', array('odbery' => $odbery));
    }
 
}
