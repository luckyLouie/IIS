<?php

namespace DistribuceTisku\Bundle\Controller;

use DistribuceTisku\Bundle\Entity\Customer;
use DistribuceTisku\Bundle\Form\CustomerType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CustomerController extends Controller {

    function getCustomerByName($name) {
        $customer = new Customer();
        $conn = $this->get('database_connection');
        $sql = "SELECT * FROM zakaznik z JOIN users u ON z.id_zakaznika=u.person_id  WHERE u.user_id='" . $name . "';";
        $users = $conn->fetchAll($sql);
        foreach ($users as $user) {
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
    function customerNameToId($name) {
        $conn = $this->get('database_connection');
        $sql = "SELECT * FROM zakaznik z JOIN users u ON z.id_zakaznika=u.person_id  WHERE u.user_id='" . $name . "';";
        $users = $conn->fetchAll($sql);
        foreach ($users as $user) {
            return $user['id_zakaznika'];
        }
    }
    
    public function customerAddAction() {
        $customer = new Customer();
        $form = $this->createForm(new CustomerType(), $customer);

        $request = $this->getRequest();
        if ($request->getMethod() == 'POST') {
            $form->bind($request);

            if ($form->isValid()) {
                $c = $request->get("customer");

                $conn = $this->get('database_connection');

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

                $this->get('session')->getFlashBag()->add('vlozeni', 'Nový zákazník byl úspěšně vložen');
                return $this->redirect($this->generateUrl('_customerAdd'));
            }
        }
        return $this->render('DistribuceTiskuBundle:Form:customerAdd.html.twig', array(
                    'form' => $form->createView()
        ));
    }

    public function customerEditAction() {
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
        $customer = $this->getCustomerById($id);
        $form = $this->createForm(new CustomerType(), $customer);
        $request = $this->getRequest();
        if ($request->getMethod() == 'POST') {
            $c = $request->get("customer");

            $conn = $this->get('database_connection');
            $conn->update('zakaznik', $c, array('id_zakaznika' => $id));
        }
        return $this->render('DistribuceTiskuBundle:Form:customeredit.html.twig', array(
                    'form' => $form->createView()
        ));
    }

    public function customerEditByNameAction($name) {
        $customer = $this->getCustomerByName($name);
        $id = customerNameToId($name);
        $form = $this->createForm(new CustomerType(), $customer);
        $request = $this->getRequest();
        if ($request->getMethod() == 'POST') {
            $c = $request->get("customer");

            $conn = $this->get('database_connection');
            $conn->update('zakaznik', $c, array('id_zakaznika' => $id));
        }
        return $this->render('DistribuceTiskuBundle:Form:customeredit.html.twig', array(
                    'form' => $form->createView()
        ));
    }
    
    public function customerListAction() {
        $request = $this->getRequest();
        if ($request->getMethod() == 'POST') {
            
        }
        $conn = $this->get('database_connection');
        $zakaznici = $conn->fetchAll('SELECT * FROM zakaznik ORDER BY id_zakaznika ASC');
        return $this->render('DistribuceTiskuBundle:Form:customerlist.html.twig', array('zakaznici' => $zakaznici));
    }

    public function customerRemoveByIdAction($id) {
        $conn = $this->get('database_connection');
        $conn->delete('users', array('person_id' => $id));
        $conn->delete('zakaznik', array('id_zakaznika' => $id));
        return $this->redirect($this->generateUrl('_customerList'));
    }

    public function customerRemoveAction() {
        $conn = $this->get('database_connection');
        return $this->redirect($this->generateUrl('_customerList'));
        ;
    }

}
