<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DashboardController extends Controller
{
    /**
     * @Route("/admin")
     */
    public function adminAction()
    {
        # get username
        $username = $this->getUser()->getUsername();
        $this->data['username']= $username;



        return $this->render('AppBundle:dashboard:index.html.twig',$this->data);
    }

}
