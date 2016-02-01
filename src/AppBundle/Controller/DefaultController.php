<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    /**
     * @Route("/tests", name="homepage")
     */
    public function index2Action(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', array(
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
        ));
    }

    /**
     * @Route("/", name="test")
     */

    public function indexAction(Request $request)
    {

        $session = $request->getSession();

        // guarda un atributo para reutilizarlo durante una
        // petición posterior del usuario
        $session->set('foo', 'bar');

        // obtener el valor de un atributo de la sesión
        $foo = $session->get('foo');
        print_r($foo);
        echo "<pre>";
        print_r($_SESSION);
        echo "</pre>";


        $this->data['blog_entries']= array(
          array(
              'title'=> '1',
              'body' => 'adsad'
          )
        );

        return $this->render('AppBundle:default:index.html.twig',$this->data);
    }

    /**
     * @Route("/admin")
     */
    public function adminAction()
    {
        return new Response('<html><body>Admin page!</body></html>');
    }

}
