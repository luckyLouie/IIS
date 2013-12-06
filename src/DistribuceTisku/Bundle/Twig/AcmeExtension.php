<?php

namespace DistribuceTisku\Bundle\Twig;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\HttpFoundation\Session\Session;

class AcmeExtension extends \Twig_Extension
{
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('session', array($this, 'testSession')),
        );
    }

    public function testSession()
    {
       // try{
       /*
            $session = $this->container->get('session');
            $maxIdleTime = 10;
            if ((time() - $session->get('LAST_ACTIVITY') > $$maxIdleTime)) {
                    $session->clear();
                    return "session destroy";
            }
            $session->set('LAST_ACTIVITY', time());
            return "adssd";
            return $session->get('LAST_ACTIVITY')."      ".time();*/
       // }catch(\Exception $e){
        //    return "exception";
       // }
    }

    public function getName()
    {
        return 'acme_extension';
    }
}