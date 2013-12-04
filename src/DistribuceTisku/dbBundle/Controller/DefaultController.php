<?php

namespace DistribuceTisku\dbBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('DistribuceTiskudbBundle:Default:index.html.twig', array('name' => $name));
    }
}
