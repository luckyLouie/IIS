<?php

namespace DistribuceTisku\Bundle\Controller;

use DistribuceTisku\Bundle\Entity\Customer;
use DistribuceTisku\Bundle\Form\CustomerType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CustomerController extends UpperController {

    function getCustomerByName($name) {
        $customer = new Customer();
        $conn = $this->get('database_connection');
        $sql = "SELECT * FROM zakaznik z JOIN users u ON z.id_zakaznika=u.person_id  WHERE u.user_id='" . $name . "';";
        $users = $conn->fetchAll($sql);
        foreach ($users as $user) {
            $customer->setId($user['id_zakaznika']);
            $customer->setJmeno($user['jmeno']);
            $customer->setPrijmeni($user['prijmeni']);
            $customer->setAdresa($user['adresa']);
            $customer->setBankovniSpojeni($user['bankovni_spojeni']);
            $customer->setPsc($user['psc']);
            $customer->setTelefon($user['kontaktni_udaj']);
            $customer->setTitul($user['titul']);
            return $customer;
        }
    }

    function getCustomerById($id) {
        $customer = new Customer();
        $conn = $this->get('database_connection');
        $sql = "SELECT * FROM zakaznik WHERE id_zakaznika='" . $id . "';";
        $users = $conn->fetchAll($sql);
        foreach ($users as $user) {
            $customer->setId($user['id_zakaznika']);
            $customer->setJmeno($user['jmeno']);
            $customer->setPrijmeni($user['prijmeni']);
            $customer->setAdresa($user['adresa']);
            $customer->setBankovniSpojeni($user['bankovni_spojeni']);
            $customer->setPsc($user['psc']);
            $customer->setTelefon($user['kontaktni_udaj']);
            $customer->setTitul($user['titul']);
            return $customer;
        }
    }

    public function customerAddAction() {
        if(($pom = $this->timeCheck()) != "") {return $this->render($pom);}
        $customer = new Customer();
        $form = $this->createForm(new CustomerType(), $customer);
        $conn = $this->get('database_connection');
        $request = $this->getRequest();
        if ($request->getMethod() == 'POST') {
            $form->bind($request);

            if ($form->isValid()) {
                try{
                    $c = $request->get("customer");

                    //$conn = $this->get('database_connection');
                    $conn->beginTransaction();        
                    $sql = "INSERT INTO `zakaznik` (`id_zakaznika`, `jmeno`, `prijmeni`, `titul`, `adresa`, `psc`, `bankovni_spojeni`, `kontaktni_udaj`, `id_dodavatele`) VALUES (NULL, '" . $c['jmeno'] . "', '" . $c['prijmeni'] . "', '" . $c['titul'] . "', '" . $c['adresa'] . "', '" . $c['psc'] . "', '" . $c['bankovniSpojeni'] . "', '" . $c['telefon'] . "', '1')";
                    $stmt = $conn->prepare($sql);
                    $stmt->execute();

                    $sql = "SELECT `id_zakaznika` FROM `zakaznik` WHERE `jmeno` = '" . $c['jmeno'] . "' AND `prijmeni` = '" . $c['prijmeni'] . "' AND `adresa` = '" . $c['adresa'] . "' LIMIT 1";
                    $stmt = $conn->prepare($sql);
                    $stmt->execute();

                    foreach ($stmt as $type) {
                        $id = $type["id_zakaznika"];
                    }

                    $sql = "INSERT INTO `users` (`user_id`, `passwd`, `type`, `person_id`) VALUES ('" . $c['login'] . "', '" . $c['password'] . "', '2', '" . $id . "')";
                    $stmt = $conn->prepare($sql);
                    $stmt->execute();
                    $conn->commit();    
                    $this->get('session')->getFlashBag()->add('ok', 'Nový zákazník byl úspěšně vložen');
                    return $this->redirect($this->generateUrl('_customerAdd'));
                }catch(\Exception $e){
                    $this->get('session')->getFlashBag()->add('exception', 'Vyskytla se chyba pri vytvareni noveho zakaznika.');
                    return $this->render('DistribuceTiskuBundle:Form:customeradd.html.twig', array(
            'form' => $form->createView() ));
                }
            }
        }
        return $this->render('DistribuceTiskuBundle:Form:customerAdd.html.twig', array(
                    'form' => $form->createView()
        ));
    }

    // pouziva se to?? NOPE
    public function customerEditAction() {
        if(($pom = $this->timeCheck()) != "") {return $this->render($pom);}
        $user = $this->getRequest()->getSession()->get("user");
        $customer = $this->getCustomerByName($user);
        //$customer->setLogin("login");

        $form = $this->createForm(new CustomerType(), $customer);


        $request = $this->getRequest();
        if ($request->getMethod() == 'POST') {
            $c = $request->get("customer");
            // nefaka
            $conn->update('zakaznik', array('username' => 'jwage'), array('id' => 1));
        }
        return $this->render('DistribuceTiskuBundle:Form:customeredit.html.twig', array(
                    'form' => $form->createView()
        ));
    }

    public function customerEditByIdAction($id) {
        if(($pom = $this->timeCheck()) != "") {return $this->render($pom);}
        $customer = $this->getCustomerById($id);
        $form = $this->createForm(new CustomerType(), $customer);
        $request = $this->getRequest();
        if ($request->getMethod() == 'POST') {
            $c = $request->get("customer");

            $conn = $this->get('database_connection');
            $sql = "UPDATE `zakaznik` SET jmeno='" . $c['jmeno'] . "', prijmeni='" . $c['prijmeni'] . "', adresa='" . $c['adresa'] . "', titul='" . $c['titul'] . "', ";
            $sql .= "psc='" . $c['psc'] . "', bankovni_spojeni='" . $c['bankovniSpojeni'] . "', kontaktni_udaj='" . $c['telefon'] . "' WHERE id_zakaznika=" . $id;
            $stmt = $conn->prepare($sql);
            $stmt->execute();

            //nacteni nejnovejsich dat o uzivateli
            $customer = $this->getCustomerById($id);
            $form = $this->createForm(new CustomerType(), $customer);
            return $this->render('DistribuceTiskuBundle:Form:customeredit.html.twig', array(
            'form' => $form->createView()));
        }
        return $this->render('DistribuceTiskuBundle:Form:customeredit.html.twig', array(
                    'form' => $form->createView()
        ));
    }

    public function customerEditByNameAction($name) {
        if(($pom = $this->timeCheck()) != "") {return $this->render($pom);}
        $customer = $this->getCustomerByName($name);        
        $id = customerNameToId($name);
        $form = $this->createForm(new CustomerType(), $customer);
        $request = $this->getRequest();
        if ($request->getMethod() == 'POST') {
            $c = $request->get("customer");

            $conn = $this->get('database_connection');
            $sql = "UPDATE `zakaznik` SET jmeno='" . $c['jmeno'] . "', prijmeni='" . $c['prijmeni'] . "', adresa='" . $c['adresa'] . "', ";
            $sql .= "bankovni_spojeni='" . $c['bankovni_spojeni'] . "', kontaktni_udaj='" . $c['telefon'] . "' WHERE id_zakaznika=" . $id;
            $stmt = $conn->prepare($sql);
            $stmt->execute();
        }
        return $this->render('DistribuceTiskuBundle:Form:customeredit.html.twig', array(
                    'form' => $form->createView()
        ));
    }

    public function customerListAction() {
        if(($pom = $this->timeCheck()) != "") {return $this->render($pom);}
        $request = $this->getRequest();
        if ($request->getMethod() == 'POST') {
            
        }
        $conn = $this->get('database_connection');
        $zakaznici = $conn->fetchAll('SELECT * FROM zakaznik ORDER BY id_zakaznika ASC');
        return $this->render('DistribuceTiskuBundle:Form:customerlist.html.twig', array('zakaznici' => $zakaznici));
    }

    public function customerRemoveByIdAction($id) {
        if(($pom = $this->timeCheck()) != "") {return $this->render($pom);}
        $conn = $this->get('database_connection');
        $conn->delete('zakaznik', array('id_zakaznika' => $id));
        return $this->redirect($this->generateUrl('_customerList'));
    }

    // pouziva se to?
    public function customerRemoveAction() {
        if(($pom = $this->timeCheck()) != "") {return $this->render($pom);}
        $conn = $this->get('database_connection');
        return $this->redirect($this->generateUrl('_customerList'));
        ;
    }

    public function profileAction() {
       if(($pom = $this->timeCheck()) != "") {return $this->render($pom);}
        $user = $this->getRequest()->getSession()->get("user");
        $customer = $this->getCustomerByName($user);
        //$customer->setLogin("login");

        $form = $this->createForm(new CustomerType(), $customer);
        $request = $this->getRequest();
        if ($request->getMethod() == 'POST') {
            $c = $request->get("customer");

            $conn = $this->get('database_connection');
            $sql = "UPDATE `zakaznik` SET jmeno='" . $c['jmeno'] . "', prijmeni='" . $c['prijmeni'] . "', adresa='" . $c['adresa'] . "', titul='" . $c['titul'] . "', ";
            $sql .= "psc='" . $c['psc'] . "', bankovni_spojeni='" . $c['bankovniSpojeni'] . "', kontaktni_udaj='" . $c['telefon'] . "' WHERE id_zakaznika=" . $id;
            $stmt = $conn->prepare($sql);
            $stmt->execute();

            //nacteni nejnovejsich dat o uzivateli
            $customer = $this->getCustomerById($id);
            $form = $this->createForm(new CustomerType(), $customer);
            $this->get('session')->getFlashBag()->add('ok', 'Editace profilu byla úspěšná');
            return $this->render('DistribuceTiskuBundle:Form:customeredit.html.twig', array(
            'form' => $form->createView()));
        }
        return $this->render('DistribuceTiskuBundle:Form:customeredit.html.twig', array(
                    'form' => $form->createView()
        ));  
    }
}
