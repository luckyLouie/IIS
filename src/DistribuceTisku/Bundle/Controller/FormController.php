<?php

namespace DistribuceTisku\Bundle\Controller;

use DistribuceTisku\Bundle\Entity\Book;
use DistribuceTisku\Bundle\Entity\Subscription;
use DistribuceTisku\Bundle\Entity\SubscriptionInterruption;
use DistribuceTisku\Bundle\Entity\Supplier;
use DistribuceTisku\Bundle\Form\BookType;
use DistribuceTisku\Bundle\Form\SupplierType;
use DistribuceTisku\Bundle\Controller\SecurityController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class FormController extends UpperController {

    public function getBookByISSN($id) {
        if (($pom = $this->timeCheck(2)) != "") {
            return $this->render($pom);
        }
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
        if (($pom = $this->timeCheck(0)) != "") {
            return $this->render($pom);
        }
        $book = new Book();
        $form = $this->createForm(new BookType(), $book);

        $request = $this->getRequest();
        if ($request->getMethod() == 'POST') {
            $form->bind($request);

            if ($form->isValid()) {
                $c = $request->get("titul");
                $conn = $this->get('database_connection');

                $sql = "INSERT INTO `tiskovina` (`ISSN`, `cena`, `titul`, `den_vydani`, `nakladatelstvi`, `vydavatel`,`typ`) VALUES ('" . $c['issn'] . "', '" . $c['titul'] . "', '" . $c['cena'] . "', '" . $c['denVydani'] . "', '" . $c['nakladatelstvi'] . "', '" . $c['vydavatel'] . "', '" . $c['typ'] . "')";
                $stmt = $conn->prepare($sql);
                $stmt->execute();

                $this->get('session')->getFlashBag()->add('ok', 'Nová tiskovina byla úspěšně vložena');
                return $this->redirect($this->generateUrl('_bookAdd'));
            }
        }
        return $this->render('DistribuceTiskuBundle:Form:bookadd.html.twig', array(
                    'form' => $form->createView()
        ));
    }

    public function bookEditAction($id) {
        if (($pom = $this->timeCheck(0)) != "") {
            return $this->render($pom);
        }
        $book = $this->getBookByISSN($id);
        $form = $this->createForm(new BookType(), $book);
        $request = $this->getRequest();
        if ($request->getMethod() == 'POST') {
            $c = $request->get("titul");
            $conn = $this->get('database_connection');
//cena 	titul 	den_vydani 	nakladatelstvi 	vydavatel
            $sql = "UPDATE `tiskovina` SET titul='" . $c['titul'] . "',issn='" . $c['issn'] . "',cena='" . $c['cena'] . "', den_vydani='" . $c['denVydani'] . "', ";
            $sql .= "nakladatelstvi='" . $c['nakladatelstvi'] . "', vydavatel='" . $c['vydavatel'] . "' , typ='" . $c['typ'] . "' WHERE ISSN='" . $id . "'";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $this->get('session')->getFlashBag()->add('ok', 'Titul byl uspesne upraven.');
            return $this->redirect($this->generateUrl('_bookList', array( 'offset'=>'0')));
        }
        return $this->render('DistribuceTiskuBundle:Form:bookedit.html.twig', array(
                    'form' => $form->createView()
        ));
    }

    public function bookListAction($offset) {
        if (($pom = $this->timeCheck(2)) != "") {
            return $this->render($pom);
        }
        $conn = $this->get('database_connection');
        
        
        $sql = "SELECT COUNT( * ) FROM `tiskovina` ";
        $count = $conn->prepare($sql);
        $count->execute();
        $sql = "SELECT * FROM tiskovina ORDER BY titul ASC";
        if($count > $offset){
            $sql = $sql." LIMIT ".$offset." , 10";
            $offset = $offset+10;
        }
        $books = $conn->prepare($sql);
        $books->execute();
        
        //$books = $conn->fetchAll('SELECT * FROM tiskovina ORDER BY titul ASC');
        
        return $this->render('DistribuceTiskuBundle:Form:booklist.html.twig', array('books' => $books, 'offset' => $offset));
    }
    
        public function bookDeleteByIdAction($id) {
        if (($pom = $this->timeCheck(0)) != "") {
            return $this->render($pom);
        }
        $conn = $this->get('database_connection');
        
        $conn->delete('tiskovina', array('ISSN' => $id));
        $this->get('session')->getFlashBag()->add('ok', 'Tiskovina byla úspěšně smazána');
        return $this->redirect($this->generateUrl('_bookList', array('offset'=>'0')));
    }

    public function supplierAddAction() {
        if (($pom = $this->timeCheck(0)) != "") {
            return $this->render($pom);
        }
        $supplier = new Supplier();
        $form = $this->createForm(new SupplierType(), $supplier);

        $request = $this->getRequest();
        if ($request->getMethod() == 'POST') {
            $form->bind($request);

            if ($form->isValid()) {
                try {
                    $c = $request->get("supplier");


                    $conn = $this->get('database_connection');
                    $conn->beginTransaction();
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
                    $conn->commit();
                    $this->get('session')->getFlashBag()->add('ok', 'Nový dodavatel byl úspěšně vložen');
                    return $this->redirect($this->generateUrl('_supplierAdd'));
                } catch (\Exception $e) {
                    $this->get('session')->getFlashBag()->add('exception', 'Vyskytla se chyba pri vytvareni noveho doručovatele.');
                    return $this->redirect($this->generateUrl('_supplierAdd'));
                }
            }
        }

        return $this->render('DistribuceTiskuBundle:Form:supplierAdd.html.twig', array(
                    'form' => $form->createView()
        ));
    }

    public function supplierEditAction($id) {
        if (($pom = $this->timeCheck(0)) != "") {
            return $this->render($pom);
        }
        $suplier = new Supplier();
        $conn = $this->get('database_connection');
        $sql = "SELECT * FROM `dodavatel` WHERE id_dodavatele = '" . $id . "'";
        $dodavatele = $conn->prepare($sql);
        $dodavatele->execute();
        foreach ($dodavatele as $dodavatel) {
            $suplier->setJmeno($dodavatel['jmeno']);
            $suplier->setPrijmeni($dodavatel['prijmeni']);
            $suplier->setAdresa($dodavatel['adresa']);
            $suplier->setPsc($dodavatel['psc']);
            $suplier->setTelefon($dodavatel['kontaktni_udaj']);
            $suplier->setId($id);
        }
        $form = $this->createForm(new SupplierType(), $suplier);
        $request = $this->getRequest();
        if ($request->getMethod() == 'POST') {
            $c = $request->get("supplier");
            $sql = "UPDATE `dodavatel` SET `jmeno` = '" . $c['jmeno'] . "', `prijmeni` = '" . $c['prijmeni'] . "', `adresa` = '" . $c['adresa'] . "', `psc` = '" . $c['psc'] . "', `kontaktni_udaj` = '" . $c['telefon'] . "' WHERE `id_dodavatele` = '" . $id . "'";
            $stmt = $conn->prepare($sql);
            $stmt->execute();

            $this->get('session')->getFlashBag()->add('ok', 'Editace dodavatele byla úspěšná');
            return $this->redirect($this->generateUrl('_supplierList',array('offset'=>'0')));
        }

        return $this->render('DistribuceTiskuBundle:Form:supplierEdit.html.twig', array(
                    'form' => $form->createView(),
        ));
    }

    public function dprofileAction() {
        if (($pom = $this->timeCheck(2)) != "") {
            return $this->render($pom);
        }
        $session = $this->getRequest()->getSession();
        $id = $this->supplierNameToId($session->get('user'));
        $request = $this->getRequest();

        $suplier = new Supplier();
        $conn = $this->get('database_connection');
        $sql = "SELECT * FROM `dodavatel` WHERE id_dodavatele = '" . $id . "'";
        $dodavatele = $conn->prepare($sql);
        $dodavatele->execute();
        foreach ($dodavatele as $dodavatel) {
            $suplier->setJmeno($dodavatel['jmeno']);
            $suplier->setPrijmeni($dodavatel['prijmeni']);
            $suplier->setAdresa($dodavatel['adresa']);
            $suplier->setPsc($dodavatel['psc']);
            $suplier->setTelefon($dodavatel['kontaktni_udaj']);
            $suplier->setId($id);
        }
        $form = $this->createForm(new SupplierType(), $suplier);
        $request = $this->getRequest();
        if ($request->getMethod() == 'POST') {
            $c = $request->get("supplier");
            $sql = "UPDATE `dodavatel` SET `jmeno` = '" . $c['jmeno'] . "', `prijmeni` = '" . $c['prijmeni'] . "', `adresa` = '" . $c['adresa'] . "', `psc` = '" . $c['psc'] . "', `kontaktni_udaj` = '" . $c['telefon'] . "' WHERE `id_dodavatele` = '" . $id . "'";
            $stmt = $conn->prepare($sql);
            $stmt->execute();

            $this->get('session')->getFlashBag()->add('ok', 'Editace dodavatele byla úspěšná');
            return $this->redirect($this->generateUrl('_dprofile'));
        }

        return $this->render('DistribuceTiskuBundle:Form:dsupplierEdit.html.twig', array(
                    'form' => $form->createView()
        ));
    }
    
    public function supplierListAction($offset) {
        if (($pom = $this->timeCheck(1)) != "") {
            return $this->render($pom);
        }
        
        $conn = $this->get('database_connection');        
        $sql = "SELECT COUNT( * ) FROM `dodavatel` ";
        $count = $conn->prepare($sql);
        $count->execute();
        $sql = "SELECT * FROM `dodavatel`";
        if($count > $offset){
            $sql = $sql." LIMIT ".$offset." , 10";
            $offset = $offset+10;
        }
        $dodavatel = $conn->prepare($sql);
        $dodavatel->execute();
        return $this->render('DistribuceTiskuBundle:Form:supplierList.html.twig', array('dodavatele' => $dodavatel, 'offset' => $offset));
    }

    private function getSupplierSubsList($id) {
        $conn = $this->get('database_connection');
        $sql = "SELECT `odber`.`id_odberu`, `odber`.`den_odberu`,`odber`.`odber_od`,`odber`.`odber_do`,`odber`.`id_platby`,`zakaznik`.`jmeno`,`zakaznik`.`prijmeni`,`zakaznik`.`adresa`,`oblast`.`psc`,`oblast`.`nazev`,`oblast`.`posta`,`zakaznik`.`kontaktni_udaj`,`tiskovina`.`titul`,`tiskovina`.`issn`,`zakaznik`.`id_dodavatele`  FROM `odber`";
        $sql = $sql . "JOIN `zakaznik` ON `odber`.`id_zakaznika` = `zakaznik`.`id_zakaznika`";
        $sql = $sql . "JOIN `tiskovina` ON `odber`.`ISSN` = `tiskovina`.`ISSN` ";
        $sql = $sql . "JOIN `dodavatel` ON `dodavatel`.`id_dodavatele` = `zakaznik`.`id_dodavatele` ";
        $sql = $sql . "JOIN `oblast` ON `oblast`.`id_oblast` = `zakaznik`.`psc` ";
        $sql = $sql . " WHERE `dodavatel`.`id_dodavatele`=" . $id;
        $sql = $sql . " ORDER BY FIELD(`odber`.`den_odberu`, 'Pondělí', 'Úterý', 'Středa', 'Čtvrtek', 'Pátek','Sobota', 'Neděle')";

        $odbery = $conn->prepare($sql);
        $odbery->execute();
        return $odbery;
    }

    public function supplierSubsListAction($id) {
        if (($pom = $this->timeCheck(1)) != "") {
            return $this->render($pom);
        }
        $session = $this->getRequest()->getSession();
        if ($session->get('type') == 1) {
            $id = $this->supplierNameToId($session->get('user'));
        }
        $odbery = $this->getSupplierSubsList($id);
        return $this->render('DistribuceTiskuBundle:Form:supplierSubsList.html.twig', array('odbery' => $odbery));
    }

    public function dsupplierSubsListAction() {
        if (($pom = $this->timeCheck(1)) != "") {
            return $this->render($pom);
        }
        $session = $this->getRequest()->getSession();

        $id = $this->supplierNameToId($session->get('user'));

        $odbery = $this->getSupplierSubsList($id);
        return $this->render('DistribuceTiskuBundle:Form:dsupplierSubsList.html.twig', array('odbery' => $odbery));
    }

    public function supplierDeleteAction($id) {
        if (($pom = $this->timeCheck(0)) != "") {
            return $this->render($pom);
        }
        $conn = $this->get('database_connection');
        $conn->delete('dodavatel', array('id_dodavatele' => $id));
        $this->get('session')->getFlashBag()->add('ok', 'Doručovatel byl úspěšně smazán');
        return $this->redirect($this->generateUrl('_supplierList',array('offset'=>'0')));
    }

    private function getSubscripsionById($id) {
        $subscription = new Subscription();
        $conn = $this->get('database_connection');
        $sql = "SELECT * FROM `odber` WHERE id_odberu = '" . $id . "'";
        $odbery = $conn->prepare($sql);
        $odbery->execute();
        foreach ($odbery as $odber) {
            $subscription->setUzivatel($odber['id_zakaznika']);
            $subscription->setDenOdberu($odber['den_odberu']);
            $subscription->setZakaznik($odber['id_zakaznika']);
            $subscription->setTitul($odber['ISSN']);
            $subscription->setIssn($odber['ISSN']);
            $subscription->setId($id);
            $subscription->setOdberOd($odber['odber_od']);
            $subscription->setOdberDo($odber['odber_do']);
        }
        return $subscription;
    }

    function makeSubscriptionForm($subscription, $od = NULL, $do = NULL) {
        $currDate = new \DateTime();
        //$currDate = $date->format('yyyy-MM-dd');
        $od = ($od == NULL) ? $currDate : $od;
        $do = ($do == NULL) ? $currDate : $do;
        $conn = $this->get('database_connection');
        $uzivatele = $conn->fetchAll('SELECT `jmeno`, `id_zakaznika` FROM `zakaznik`');

        foreach ($uzivatele as $one) {
            $uzivatel[$one['id_zakaznika']] = $one['jmeno'];
        }

        $uzivatele = $conn->fetchAll('SELECT `ISSN`, `titul` FROM `tiskovina`');

        foreach ($uzivatele as $one) {
            $titul[$one['ISSN']] = $one['titul'];
        }

        $form = $this->createFormBuilder($subscription)
                ->add('uzivatel', 'choice', array('choices' => $uzivatel))
                ->add('denOdberu', 'choice', array('choices' => array(
                        'Pondělí' => 'Pondělí',
                        'Úterý' => 'Úterý',
                        'Středa' => 'Středa',
                        'Čtvrtek' => 'Čtvrtek',
                        'Pátek' => 'Pátek',
                        'Sobota' => 'Sobota',
                        'Neděle' => 'Neděle'
            )))
                ->add('odberOd', 'date', array(
                    'format' => 'yyyy-MM-dd',
                    'years' => range(Date('Y'), 2020),
                    'data' => $od
                ))
                ->add('odberDo', 'date', array(
                    'format' => 'yyyy-MM-dd',
                    'years' => range(Date('Y'), 2020),
                    'data' => $do
                ))
                ->add('titul', 'choice', array('choices' => $titul))
                ->getForm();
        return $form;
    }

    public function subscriptionAddAction() {
        if (($pom = $this->timeCheck(0)) != "") {
            return $this->render($pom);
        }
        $subscription = new Subscription();

        $form = $this->makeSubscriptionForm($subscription);
        $request = $this->getRequest();
        $form->handleRequest($request);

        if ($form->isValid()) {
            $c = $request->get("form");
            $conn = $this->get('database_connection');
            $sql = "INSERT INTO `odber` (`den_odberu`, `odber_od`, `odber_do`, `id_zakaznika`, `ISSN`) VALUES ('" . $c['denOdberu'] . "', '" . $c['odberOd']['year'] . "-" . $c['odberOd']['month'] . "-" . $c['odberOd']['day'] . "', '" . $c['odberDo']['year'] . "-" . $c['odberDo']['month'] . "-" . $c['odberDo']['day'] . "', '" . $c['uzivatel'] . "', '" . $c['titul'] . "')";
            $stmt = $conn->prepare($sql);
            $stmt->execute();

            $this->get('session')->getFlashBag()->add('ok', 'Nový odběr byl úspěšně vložen');
            return $this->redirect($this->generateUrl('_subscriptionAdd'));
        }

        return $this->render('DistribuceTiskuBundle:Form:subscriptionAdd.html.twig', array(
                    'form' => $form->createView()
        ));
    }

    public function subscriptionEditAction($id) {
        if (($pom = $this->timeCheck(0)) != "") {
            return $this->render($pom);
        }
        $subscription = $this->getSubscripsionById($id);
        $od = new \DateTime($subscription->getOdberOd());
        $do = new \DateTime($subscription->getOdberDo());
        $form = $this->makeSubscriptionForm($subscription, $od, $do);
        $request = $this->getRequest();
        //$form->handleRequest($request);
        if ($request->getMethod() == 'POST') {

            $conn = $this->get('database_connection');
            $c = $request->get("form");
            $sql = "UPDATE `odber` SET `den_odberu` = '" . $c['denOdberu'] . "', `odber_od` = '" . $c['odberOd']['year'] . "-" . $c['odberOd']['month'] . "-" . $c['odberOd']['day'] . "', `odber_do` = '" . $c['odberDo']['year'] . "-" . $c['odberDo']['month'] . "-" . $c['odberDo']['day'] . "', `id_zakaznika` = '" . $c['uzivatel'] . "', `ISSN` = '" . $c['titul'] . "' WHERE `odber`.`id_odberu` = '" . $id . "'";
            $stmt = $conn->prepare($sql);
            $stmt->execute();

            $this->get('session')->getFlashBag()->add('ok', 'Editace odběru byla úspěšná');
            return $this->redirect($this->generateUrl('_subscriptionList', array('offset' => '0') ));
        }

        return $this->render('DistribuceTiskuBundle:Form:subscriptionEdit.html.twig', array(
                    'form' => $form->createView()
        ));
    }

    private function getSubscriptionList($id = "", $offset) {
        if (($pom = $this->timeCheck(2)) != "") {
            return $this->render($pom);
        }
        $conn = $this->get('database_connection');
        
        if ($id != "") {
            $sql = "SELECT COUNT( `odber`.`id_platby` ) FROM `odber` WHERE `odber`.`id_zakaznika`=" . $id;
            $count = $conn->prepare($sql);
            $count->execute();
            $sql = "SELECT `platby`.`obdobi`,`platby`.`zpusob_platby`,`odber`.`id_odberu`, `odber`.`den_odberu`,`odber`.`odber_od`,`odber`.`odber_do`,`odber`.`id_platby`,`zakaznik`.`jmeno`,`zakaznik`.`prijmeni`,`tiskovina`.`titul`  FROM `odber`";
            $sql = $sql . "JOIN `zakaznik` ON `odber`.`id_zakaznika` = `zakaznik`.`id_zakaznika`";
            $sql = $sql . "JOIN `tiskovina` ON `odber`.`ISSN` = `tiskovina`.`ISSN` ";
            $sql = $sql . "JOIN `platby` ON `odber`.`id_platby` = `platby`.`id_platby` ";
            $sql = $sql . " WHERE `odber`.`id_zakaznika`=" . $id;
        } else {
            $sql = "SELECT COUNT( `odber`.`id_platby` ) FROM `odber`";
            $count = $conn->prepare($sql);
            $count->execute();
            $sql = "SELECT `odber`.`id_odberu`, `odber`.`den_odberu`,`odber`.`odber_od`,`odber`.`odber_do`,`odber`.`id_platby`,`zakaznik`.`jmeno`,`zakaznik`.`prijmeni`,`tiskovina`.`titul`  FROM `odber`";
            $sql = $sql . "JOIN `zakaznik` ON `odber`.`id_zakaznika` = `zakaznik`.`id_zakaznika`";
            $sql = $sql . "JOIN `tiskovina` ON `odber`.`ISSN` = `tiskovina`.`ISSN` ";
        }


        $sql = $sql . " ORDER BY `odber`.`id_odberu`";
        if($count > $offset){
            $sql = $sql." LIMIT ".$offset." , 10";
            $offset = $offset+10;
        }
        $odbery = $conn->prepare($sql);
        $odbery->execute();
    return array( 'odbery' => $odbery, 'offset' => $offset);
    }

    public function subscriptionListAction($offset) {
        if (($pom = $this->timeCheck(0)) != "") {
            return $this->render($pom);
        }
        $odbery = $this->getSubscriptionList("", $offset);
        return $this->render('DistribuceTiskuBundle:Form:subscriptionList.html.twig', array('odbery' => $odbery['odbery'], 'offset' => $odbery['offset']));
    }

    public function subscriptionInterruptionAction($id) {
        if (($pom = $this->timeCheck(2)) != "") {
            return $this->render($pom);
        }
        $interuption = new SubscriptionInterruption();
        $interuption->setId($id);
        $form = $this->createFormBuilder($interuption)
                ->add('od', 'date', array(
                    'format' => 'yyyy-MM-dd',
                    'data' => new \DateTime(),
                    'years' => range(Date('Y'), 2020)
                ))
                ->add('do', 'date', array(
                    'format' => 'yyyy-MM-dd',
                    'data' => new \DateTime(),
                    'years' => range(Date('Y'), 2020)
                ))
                ->getForm();

        $request = $this->getRequest();
        if ($request->getMethod() == 'POST') {
            $form->bind($request);

            if ($form->isValid()) {
                $c = $request->get("form");
                $conn = $this->get('database_connection');

                $sql = "INSERT INTO `preruseni_odberu` (`preruseni_od`, `preruseni_do`, `id_odberu`) VALUES ('" . $c['od']['year'] . "-" . $c['od']['month'] . "-" . $c['od']['day'] . "', '" . $c['do']['year'] . "-" . $c['do']['month'] . "-" . $c['do']['day'] . "', '" . $id . "')";
                $stmt = $conn->prepare($sql);
                $stmt->execute();

                $this->get('session')->getFlashBag()->add('ok', 'Nové přerušení bylo nastaveno');
                $session = $this->getRequest()->getSession();
                if ($session->get('type') == 2)
                    return $this->redirect($this->generateUrl('_usubscriptionList', array('offset' => '0') ));
                else
                    return $this->redirect($this->generateUrl('_subscriptionList', array('offset' => '0') ));
            }
        }
        return $this->render('DistribuceTiskuBundle:Form:subscriptionInterruption.html.twig', array(
                    'form' => $form->createView()
        ));
    }

    public function subscriptionRemoveAction($id) {
        if (($pom = $this->timeCheck(2)) != "") {
            return $this->render($pom);
        }
        $conn = $this->get('database_connection');
        $conn->delete('odber', array('id_odberu' => $id));
        $conn->delete('preruseni_odberu', array('id_odberu' => $id));
        return $this->redirect($this->generateUrl('_subscriptionList', array('offset' => '0') ));
    }

    public function subscriptionInterruptionListAction($id, $offset) {
        if (($pom = $this->timeCheck(2)) != "") {
            return $this->render($pom);
        }
        $request = $this->getRequest();
        $conn = $this->get('database_connection');
        
        $sql = "SELECT COUNT( * ) FROM `preruseni_odberu` ";
        $count = $conn->prepare($sql);
        $count->execute();
        
        $sql = "SELECT `id_preruseni`, `preruseni_od`, `preruseni_do` FROM `preruseni_odberu` WHERE `id_odberu` = '" . $id . "'";
        if($count > $offset){
            $sql = $sql." LIMIT ".$offset." , 10";
            $offset = $offset+10;
        }
        $preruseni = $conn->prepare($sql);
        $preruseni->execute();
        
        return $this->render('DistribuceTiskuBundle:Form:subscriptionInterruptionList.html.twig', array('interuptions' => $preruseni, 'id' => $id, 'offset' => $offset));
    }

    public function subscriptionInteruptionDeleteAction($id) {
        if (($pom = $this->timeCheck(2)) != "") {
            return $this->render($pom);
        }
        $conn = $this->get('database_connection');

        $conn->delete('preruseni_odberu', array('id_preruseni' => $id));
        $this->get('session')->getFlashBag()->add('ok', 'Přerusení odberu bylo úspěšně smazáno');
        $sql = "SELECT `id_preruseni`, `preruseni_od`, `preruseni_do` FROM `preruseni_odberu`";
        $preruseni = $conn->prepare($sql);
        $preruseni->execute();

        return $this->render('DistribuceTiskuBundle:Form:subscriptionInterruptionList.html.twig', array('interuptions' => $preruseni, 'offset'=> '0'));
    }

    //******************************************************************************
    //******************USER********************************************************

    public function ubookListAction($offset) {
        if (($pom = $this->timeCheck(2)) != "") {
            return $this->render($pom);
        }
        $conn = $this->get('database_connection');
        $sql = "SELECT COUNT(*) FROM tiskovina";
        $count = $conn->prepare($sql);
        $count->execute();
        $sql = "SELECT * FROM tiskovina ORDER BY titul ASC";
        if($count > $offset){
            $sql = $sql." LIMIT ".$offset." , 10";
            $offset = $offset+10;
        }
        $books = $conn->prepare($sql);
        $books->execute();
        return $this->render('DistribuceTiskuBundle:Form:ubooklist.html.twig', array('books' => $books, 'offset' => $offset));
    }

    public function usubscriptionListAction($offset) {
        if (($pom = $this->timeCheck(2)) != "") {
            return $this->render($pom);
        }
        $session = $this->getRequest()->getSession();
        $odbery = $this->getSubscriptionList($session->get('id'), $offset);
        //$odbery = $this->getSubscriptionList();
        return $this->render('DistribuceTiskuBundle:Form:usubscriptionList.html.twig', array('odbery' => $odbery['odbery'], 'offset' => $odbery['offset']));
        //return $this->render('DistribuceTiskuBundle:Form:usubscriptionList.html.twig', array('odbery' => $odbery));
    }

    public function usubscriptionAddAction() {
        if (($pom = $this->timeCheck(2)) != "") {
            return $this->render($pom);
        }
        $user = $this->getRequest()->getSession()->get("user");
        $id = $this->customerNameToId($user);
        $subscription = new Subscription();
        $subscription->setOdberDo(2013);
        $form = $this->makeSubscriptionForm($subscription);
        $request = $this->getRequest();
        $form->handleRequest($request);

        if ($form->isValid()) {
            $c = $request->get("form");
            $conn = $this->get('database_connection');
            $sql = "INSERT INTO `odber` (`den_odberu`, `odber_od`, `odber_do`, `id_zakaznika`, `ISSN`) VALUES ('" . $c['denOdberu'] . "', '" . $c['odberOd']['year'] . "-" . $c['odberOd']['month'] . "-" . $c['odberOd']['day'] . "', '" . $c['odberDo']['year'] . "-" . $c['odberDo']['month'] . "-" . $c['odberDo']['day'] . "', '" . $id . "', '" . $c['titul'] . "')";
            $stmt = $conn->prepare($sql);
            $stmt->execute();

            $this->get('session')->getFlashBag()->add('ok', 'Nový odběr byl úspěšně vložen');
            return $this->redirect($this->generateUrl('_usubscriptionAdd'));
        }

        return $this->render('DistribuceTiskuBundle:Form:usubscriptionAdd.html.twig', array(
                    'form' => $form->createView()
        ));
    }

    public function usubscriptionEditAction($id) {
        if (($pom = $this->timeCheck(2)) != "") {
            return $this->render($pom);
        }
        $subscription = $this->getSubscripsionById($id);
        $od = new \DateTime($subscription->getOdberOd());
        $do = new \DateTime($subscription->getOdberDo());
        $form = $this->makeSubscriptionForm($subscription, $od, $do);

        $request = $this->getRequest();
        //$form->handleRequest($request);
        if ($request->getMethod() == 'POST') {
            $c = $request->get("form");
            $conn = $this->get('database_connection');
            $sql = "UPDATE `odber` SET `den_odberu` = '" . $c['denOdberu'] . "', `odber_od` = '" . $c['odberOd']['year'] . "-" . $c['odberOd']['month'] . "-" . $c['odberOd']['day'] . "', `odber_do` = '" . $c['odberDo']['year'] . "-" . $c['odberDo']['month'] . "-" . $c['odberDo']['day'] . "', `ISSN` = '" . $c['titul'] . "' WHERE `odber`.`id_odberu` = '" . $id . "'";
            $stmt = $conn->prepare($sql);
            $stmt->execute();

            $this->get('session')->getFlashBag()->add('ok', 'Editace odběru byla úspěšná');
            return $this->redirect($this->generateUrl('_usubscriptionList', array('offset' => '0') ));
            
        }

        return $this->render('DistribuceTiskuBundle:Form:usubscriptionEdit.html.twig', array(
                    'form' => $form->createView()
        ));
    }

}
