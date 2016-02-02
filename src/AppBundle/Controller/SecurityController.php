<?php
/**
 * Created by PhpStorm.
 * User: victor
 * Date: 02/02/16
 * Time: 12:38 PM
 */

// src/AppBundle/Controller/SecurityController.php

// ...
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class SecurityController extends Controller
{
    /**
     * @Route("/login", name="login_route")
     */
    public function loginAction(Request $request)
    {
        $data = array();
        return $this->render('AppBundle:blog:login.html.twig', array('data' => $data));
    }

    /**
     * @Route("/login_check", name="login_check")
     */
    public function loginCheckAction()
    {
        // this controller will not be executed,
        // as the route is handled by the Security system
    }
}