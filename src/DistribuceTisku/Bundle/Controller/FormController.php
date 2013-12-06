<?php

namespace DistribuceTisku\Bundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use DistribuceTisku\Bundle\Entity\Customer;
use DistribuceTisku\Bundle\Entity\Book;
use DistribuceTisku\Bundle\Entity\Supplier;
use DistribuceTisku\Bundle\Entity\Subscription;
use DistribuceTisku\Bundle\Entity\SubscriptionInterruption;
use DistribuceTisku\Bundle\Form\CustomerType;
use DistribuceTisku\Bundle\Form\BookType;
use DistribuceTisku\Bundle\Form\SupplierType;
use DistribuceTisku\Bundle\Form\SubscriptionType;
use DistribuceTisku\Bundle\Form\SubscriptionInterruptionType;

class FormController extends Controller {

    function getBookByISSN($id) {
        $b = new Book();
        $conn = $this->get('database_connection');
        $sql = "SELECT * FROM tiskovina WHERE ISSN='" . $id . "';";
        $books = $conn->fetchAll($sql);
        foreach ($books as $book) {
            $b->setIssn($book['ISSN']);
            $b->setCena($book['cena']);
            $b->setDenVydani($book['den_vydani']);
            $b->setNakladatelstvi($book['nakladatelstvi']);
            $b->setTitul($book['titul']);
            $b->setVydavatel($book['vydavatel']);
            return $b;
        }
    }

    public function bookAddAction() {
        $book = new Book();
        $form = $this->createForm(new BookType(), $book);

        $request = $this->getRequest();
        if ($request->getMethod() == 'POST') {
            $form->bind($request);

            if ($form->isValid()) {
                $c = $request->get("titul");
                $conn = $this->get('database_connection');

                $sql = "INSERT INTO `tiskovina` (`ISSN`, `cena`, `titul`, `den_vydani`, `nakladatelstvi`, `vydavatel`) VALUES ('" . $c['issn'] . "', '" . $c['titul'] . "', '" . $c['cena'] . "', '" . $c['denVydani'] . "', '" . $c['nakladatelstvi'] . "', '" . $c['vydavatel'] . "')";
                $stmt = $conn->prepare($sql);
                $stmt->execute();

                echo "is valid !!";
                $this->get('session')->getFlashBag()->add('ok', 'Nová tiskovina byla úspěšně vložena');
                return $this->redirect($this->generateUrl('_bookAdd'));
            }
        }
        return $this->render('DistribuceTiskuBundle:Form:bookAdd.html.twig', array(
                    'form' => $form->createView()
        ));
    }

    public function bookEditAction($id) {
        $book = $this->getBookByISSN($id);
        $form = $this->createForm(new BookType(), $book);
        $request = $this->getRequest();
        if ($request->getMethod() == 'POST') {
            $c = $request->get("book");

            $conn = $this->get('database_connection');
            //conn->update('zakaznik', $c, array('id_zakaznika' => $id));
        }
        return $this->render('DistribuceTiskuBundle:Form:bookedit.html.twig', array(
                    'form' => $form->createView()
        ));
    }

    public function bookListAction() {
        $request = $this->getRequest();
        if ($request->getMethod() == 'POST') {
            
        }

        $conn = $this->get('database_connection');
        $books = $conn->fetchAll('SELECT * FROM tiskovina ORDER BY titul ASC');
        return $this->render('DistribuceTiskuBundle:Form:booklist.html.twig', array('books' => $books));
    }


    public function supplierAddAction() {
        $supplier = new Supplier();
        $form = $this->createForm(new SupplierType(), $supplier);

        $request = $this->getRequest();
        if ($request->getMethod() == 'POST') {
            $form->bind($request);

            if ($form->isValid()) {
                $c = $request->get("supplier");

                $conn = $this->get('database_connection');

                $sql = "INSERT INTO `dodavatel` (`jmeno`, `prijmeni`, `adresa`, `psc`, `kontaktni_udaj`) VALUES ('" . $c['jmeno'] . "', '" . $c['prijmeni'] . "', '" . $c['adresa'] . "', '" . $c['psc'] . "', '" . $c['telefon'] . "')";
                $stmt = $conn->prepare($sql);
                $stmt->execute();

                $sql = "SELECT `id_dodavatele` FROM `dodavatel` WHERE `jmeno` = '" . $c['jmeno'] . "' AND `prijmeni` = '" . $c['prijmeni'] . "' AND `adresa` = '" . $c['adresa'] . "' LIMIT 1";
                $stmt = $conn->prepare($sql);
                $stmt->execute();

                foreach ($stmt as $type) {
                    $id = $type["id_dodavatele"];
                }

                $sql = "INSERT INTO `users` (`user_id`, `passwd`, `type`, `person_id`) VALUES ('" . $c['login'] . "', '" . $c['password'] . "', '1', '" . $id . "')";
                $stmt = $conn->prepare($sql);
                $stmt->execute();

                echo "is valid !!";
                $this->get('session')->getFlashBag()->add('ok', 'Nový dodavatel byl úspěšně vložen');
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
    
    function makeSubscriptionForm($subscription)
    {
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
        return $form;
    }
    
    public function subscriptionAddAction()
    {
        $subscription = new Subscription();
        $form = $this->makeSubscriptionForm($subscription);
        $request = $this->getRequest();
        $form->handleRequest($request);  
        
            if ($form->isValid()) {
                $c = $request->get("form");
                echo $c['odberOd']['year'];
                $conn = $this->get('database_connection');
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
    
    public function subscriptionEditAction($id)
    {
        $subscription = new Subscription();
        $conn = $this->get('database_connection');
        $sql = "SELECT * FROM `odber` WHERE id_odberu = '".$id."'";
        $odbery = $conn->prepare($sql);
        $odbery->execute();
        foreach ($odbery as $odber) {
            $subscription->setUzivatel($odber['id_zakaznika']);
            $subscription->setDenOdberu($odber['den_odberu']);
            $subscription->setZakaznik($odber['id_zakaznika']);
            $subscription->setTitul($odber['ISSN']);
            $subscription->setIssn($odber['ISSN']);
            $subscription->setId($id);
        }
        $form = $this->makeSubscriptionForm($subscription);
        $request = $this->getRequest();
        $form->handleRequest($request);
        
        if ($form->isValid()) {
                $c = $request->get("form");
                echo $c['odberOd']['year'];
                    $sql = "UPDATE `odber` SET `den_odberu` = '".$c['denOdberu']."', `odber_od` = '".$c['odberOd']['year']."-".$c['odberOd']['month']."-".$c['odberOd']['day']."', `odber_do` = '".$c['odberDo']['year']."-".$c['odberDo']['month']."-".$c['odberDo']['day']."', `id_zakaznika` = '".$c['uzivatel']."', `ISSN` = '".$c['titul']."' WHERE `odber`.`id_odberu` = '".$id."'";
                    $stmt = $conn->prepare($sql);
                    $stmt->execute();
                    echo "is valid !!";
                    $this->get('session')->getFlashBag()->add('vlozeni', 'Editace odběru byla úspěšná');
                    return $this->redirect($this->generateUrl('_subscriptionList'));
            }
            
        return $this->render('DistribuceTiskuBundle:Form:subscriptionEdit.html.twig', array(
            'form' => $form->createView()
        ));
    
    }

    public function subscriptionListAction()
    {
        $conn = $this->get('database_connection');
        $sql = "SELECT `odber`.`id_odberu`, `odber`.`den_odberu`,`odber`.`odber_od`,`odber`.`odber_do`,`odber`.`id_platby`,`zakaznik`.`jmeno`,`zakaznik`.`prijmeni`,`tiskovina`.`titul`  FROM `odber`";
        $sql = $sql."JOIN `zakaznik` ON `odber`.`id_zakaznika` = `zakaznik`.`id_zakaznika`";
        $sql = $sql."JOIN `tiskovina` ON `odber`.`ISSN` = `tiskovina`.`ISSN` ORDER BY `odber`.`id_odberu`";
        $odbery = $conn->prepare($sql);
        $odbery->execute();
        return $this->render('DistribuceTiskuBundle:Form:subscriptionList.html.twig', array('odbery' => $odbery));
    }
    
    public function subscriptionInterruptionAction($id){
        $interuption = new SubscriptionInterruption();        
        $interuption->setId($id);
        $form = $this->createFormBuilder($interuption)
            ->add('od', 'date', array(
                'input'  => 'timestamp',
                'widget' => 'choice',
                'format' => 'yyyy-MM-dd'
            ))
            ->add('do', 'date', array(
                'input'  => 'timestamp',
                'widget' => 'choice',
                'format' => 'yyyy-MM-dd'
            ))
            ->getForm();
       
        $request = $this->getRequest();
        if ($request->getMethod() == 'POST') {
            $form->bind($request);

            if ($form->isValid()) {
                $c = $request->get("interuption");
                $conn = $this->get('database_connection');

                $sql = "INSERT INTO `preruseni_odberu` (`preruseni_od`, `preruseni_do`, `id_odberu`) VALUES ('".$c['od']['year']."-".$c['od']['month']."-".$c['od']['day']."', '".$c['do']['year']."-".$c['do']['month']."-".$c['do']['day']."', '".$id."')";
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                
                echo "is valid !!";
                $this->get('session')->getFlashBag()->add('vlozeni', 'Nové přerušení bylo nastaveno');
                return $this->redirect($this->generateUrl('_subscriptionList'));
            }
        }
        return $this->render('DistribuceTiskuBundle:Form:subscriptionInterruption.html.twig', array(
            'form' => $form->createView()
        ));
    }
    
    public function subscriptionRemove($id){
        $conn = $this->get('database_connection');
        $conn->delete('odber', array('id_odberu' => $id));
        $conn->delete('preruseni_odberu', array('id_odberu' => $id));
        return $this->redirect($this->generateUrl('_subscriptionList'));
    }
    
    public function subscriptionInterruptionListAction($id)
    {
        $conn = $this->get('database_connection');
        $sql = "SELECT `id_preruseni`, `preruseni_od`, `preruseni_do` FROM `preruseni_odberu` WHERE `id_odberu` = '".$id."'";
        $preruseni = $conn->prepare($sql);
        $preruseni->execute();
        return $this->render('DistribuceTiskuBundle:Form:subscriptionInterruptionList.html.twig', array('interuptions' => $preruseni));
    }
    
    public function subscriptionInteruptionDeleteAction($id)
    {
        $conn = $this->get('database_connection');
        
        $conn->delete('preruseni_odberu', array('id_preruseni' => $id));
        
        $sql = "SELECT `id_preruseni`, `preruseni_od`, `preruseni_do` FROM `preruseni_odberu`";
        $preruseni = $conn->prepare($sql);
        $preruseni->execute();
        
        return $this->render('DistribuceTiskuBundle:Form:subscriptionInterruptionList.html.twig', array('interuptions' => $preruseni));
    }
 
}
