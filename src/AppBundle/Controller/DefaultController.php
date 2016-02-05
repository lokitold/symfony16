<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\Tools\Pagination\Paginator;

class DefaultController extends Controller
{
    /**
     * @Route("/default", name="homepage")
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

        $em = $this->getDoctrine()->getManager();
        $posts = $em->getRepository('AppBundle:Post')->findAll();

        $this->data['posts'] = $posts;

        $this->data['blog_entries']= array(
          array(
              'title'=> '1',
              'body' => 'adsad'
          )
        );

        return $this->render('AppBundle:default:index.html.twig',$this->data);
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
