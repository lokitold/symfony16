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

    /**
     * @Route("/box")
     */
    public function boxAction()
    {
        return new Response('<html><body>Box page!</body></html>');
    }

    /**
     * @Route("/box/test")
     */
    public function boxtestAction()
    {
        return new Response('<html><body>Box page test!</body></html>');
    }

}
