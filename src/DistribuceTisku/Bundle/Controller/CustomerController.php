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
            $customer->setDodavatel($user['id_dodavatele']);
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
            $customer->setDodavatel($user['id_dodavatele']);
            return $customer;
        }
    }

    public function customerAddAction() {
        if (($pom = $this->timeCheck(0)) != "") {
            return $this->render($pom);
        }
        $customer = new Customer();
        $suppliers = $this->getSuppliers();
        $areas = $this->getAreas();
        $form = $this->createForm(new CustomerType($suppliers, $areas), $customer);
        $conn = $this->get('database_connection');
        $request = $this->getRequest();
        if ($request->getMethod() == 'POST') {
            $form->bind($request);

            if ($form->isValid()) {
                try {
                    $c = $request->get("customer");

                    //$conn = $this->get('database_connection');
                    $conn->beginTransaction();
                    $sql = "INSERT INTO `zakaznik` (`id_zakaznika`, `jmeno`, `prijmeni`, `titul`, `adresa`, `psc`, `bankovni_spojeni`, `kontaktni_udaj`, `id_dodavatele`) VALUES (NULL, '" . $c['jmeno'] . "', '" . $c['prijmeni'] . "', '" . $c['titul'] . "', '" . $c['adresa'] . "', '" . $c['psc'] . "', '" . $c['bankovniSpojeni'] . "', '" . $c['telefon'] . "', '" . $c['dodavatel'] . "')";
                    $stmt = $conn->prepare($sql);
                    $stmt->execute();

                    $sql = "SELECT `id_zakaznika` FROM `zakaznik` WHERE `jmeno` = '" . $c['jmeno'] . "' AND `prijmeni` = '" . $c['prijmeni'] . "' AND `adresa` = '" . $c['adresa'] . "' LIMIT 1";
                    $stmt = $conn->prepare($sql);
                    $stmt->execute();

                    foreach ($stmt as $type) {
                        $id = $type["id_zakaznika"];
                    }

                    $sql = "INSERT INTO `users` (`user_id`, `passwd`, `type`, `person_id`) VALUES ('" . $c['login'] . "', '" . $c['password']['heslo'] . "', '2', '" . $id . "')";
                    $stmt = $conn->prepare($sql);
                    $stmt->execute();
                    $conn->commit();
                    $this->get('session')->getFlashBag()->add('ok', 'Nový zákazník byl úspěšně vložen');
                    return $this->redirect($this->generateUrl('_customerAdd'));
                } catch (\Exception $e) {
                    $this->get('session')->getFlashBag()->add('exception', 'Vyskytla se chyba pri vytvareni noveho zakaznika.');
                    return $this->render('DistribuceTiskuBundle:Form:customeradd.html.twig', array(
                                'form' => $form->createView()));
                }
            }
        }
        return $this->render('DistribuceTiskuBundle:Form:customeradd.html.twig', array(
                    'form' => $form->createView()
        ));
    }

    // pouziva se to?? NOPE
    public function customerEditAction() {
        if (($pom = $this->timeCheck(0)) != "") {
            return $this->render($pom);
        }
        $user = $this->getRequest()->getSession()->get("user");
        $customer = $this->getCustomerByName($user);
        //$customer->setLogin("login");

        $suppliers = $this->getSuppliers();
        $areas = $this->getAreas();
        $form = $this->createForm(new CustomerType($suppliers, $areas), $customer);


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
        if (($pom = $this->timeCheck(0)) != "") {
            return $this->render($pom);
        }
        $customer = $this->getCustomerById($id);
        $suppliers = $this->getSuppliers();
        $areas = $this->getAreas();
        $form = $this->createForm(new CustomerType($suppliers, $areas), $customer);
        $request = $this->getRequest();
        if ($request->getMethod() == 'POST') {
            $c = $request->get("customer");

            $conn = $this->get('database_connection');
            $sql = "UPDATE `zakaznik` SET jmeno='" . $c['jmeno'] . "', prijmeni='" . $c['prijmeni'] . "', adresa='" . $c['adresa'] . "', titul='" . $c['titul'] . "', ";
            $sql .= "psc='" . $c['psc'] . "', bankovni_spojeni='" . $c['bankovniSpojeni'] . "', kontaktni_udaj='" . $c['telefon'] . "' WHERE id_zakaznika=" . $id;
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $customer = $this->getCustomerById($id);
            $form = $this->createForm(new CustomerType($suppliers, $areas), $customer);
            //nacteni nejnovejsich dat o uzivateli
            $this->get('session')->getFlashBag()->add('ok', 'Uprava zákazníka proběhla úspěšně');
            return $this->render('DistribuceTiskuBundle:Form:customeredit.html.twig', array(
                        'form' => $form->createView()));
        }
        return $this->render('DistribuceTiskuBundle:Form:customeredit.html.twig', array(
                    'form' => $form->createView()
        ));
    }

    public function customerEditByNameAction($name) {
        if (($pom = $this->timeCheck(0)) != "") {
            return $this->render($pom);
        }
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

    public function customerListAction($offset) {
        if(($pom = $this->timeCheck(0)) != "") {return $this->render($pom);}
        $request = $this->getRequest();
        if ($request->getMethod() == 'POST') {
            
        }
        $conn = $this->get('database_connection');
        
        $sql = "SELECT COUNT( * ) FROM `zakaznik` ";
        $count = $conn->prepare($sql);
        $count->execute();
        
        $sql = "SELECT `zakaznik`.`id_zakaznika` , `oblast`.`nazev`, `oblast`.`psc`,`oblast`.`posta`, `zakaznik`.`jmeno`,`zakaznik`.`prijmeni`,`zakaznik`.`titul`,`zakaznik`.`adresa`,`zakaznik`.`bankovni_spojeni`,`zakaznik`.`kontaktni_udaj`      FROM zakaznik JOIN `oblast` ON `oblast`.`id_oblast` = `zakaznik`.`psc` ORDER BY id_zakaznika ASC";
        if($count > $offset){
            $sql = $sql." LIMIT ".$offset." , 10";
            $offset = $offset+10;
        }
        $zakaznici = $conn->prepare($sql);
        $zakaznici->execute();
        //$zakaznici = $conn->fetchAll('SELECT `zakaznik`.`id_zakaznika` , `oblast`.`nazev`, `oblast`.`psc`,`oblast`.`posta`, `zakaznik`.`jmeno`,`zakaznik`.`prijmeni`,`zakaznik`.`titul`,`zakaznik`.`adresa`,`zakaznik`.`bankovni_spojeni`,`zakaznik`.`kontaktni_udaj`      FROM zakaznik JOIN `oblast` ON `oblast`.`id_oblast` = `zakaznik`.`psc` ORDER BY id_zakaznika ASC');
        return $this->render('DistribuceTiskuBundle:Form:customerlist.html.twig', array('zakaznici' => $zakaznici, 'offset' => $offset));
    }

    public function customerRemoveByIdAction($id) {
        if (($pom = $this->timeCheck(0)) != "") {
            return $this->render($pom);
        }
        $conn = $this->get('database_connection');
        $conn->delete('zakaznik', array('id_zakaznika' => $id));
        $this->get('session')->getFlashBag()->add('ok', 'Odstranění zákazníka proběhlo úspěšně');
        return $this->redirect($this->generateUrl('_customerList'));
    }

    // pouziva se to? kdo vi? ale je to hodne nesmyslne ... testnu koment :D
    /*public function customerRemoveAction() {
        if(($pom = $this->timeCheck(0)) != "") {return $this->render($pom);}
        $conn = $this->get('database_connection');
        $this->get('session')->getFlashBag()->add('ok', 'Odstranění zákazníka proběhlo úspěšně');
        return $this->redirect($this->generateUrl('_customerList'));
        ;
    }*/

    public function profileAction() {
        if (($pom = $this->timeCheck(2)) != "") {
            return $this->render($pom);
        }
        $user = $this->getRequest()->getSession()->get("user");
        $id = $this->customerNameToId($user);
        $customer = $this->getCustomerByName($user);
        //$customer->setLogin("login");
        $suppliers = $this->getSuppliers();
        $areas = $this->getAreas();
        $form = $this->createForm(new CustomerType($suppliers, $areas), $customer);
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
            $form = $this->createForm(new CustomerType($suppliers, $areas), $customer);
            $this->get('session')->getFlashBag()->add('ok', 'Editace profilu byla úspěšná');
            return $this->render('DistribuceTiskuBundle:Form:profile.html.twig', array(
                        'form' => $form->createView()));
        }
        return $this->render('DistribuceTiskuBundle:Form:profile.html.twig', array(
                    'form' => $form->createView()
        ));
    }

}
