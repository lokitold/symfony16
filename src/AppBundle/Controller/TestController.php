<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\Post;
use AppBundle\Entity\Category;

class TestController extends Controller
{

    /**
     * @Route("/create-product", name="create-product")
     */

    public function createProductAction(Request $request)
    {
        $product = new Product();
        $product->setName('A Foo Bar');
        $product->setPrice('19.99');
        $product->setDescription('Lorem ipsum dolor');

        $em = $this->getDoctrine()->getManager();

        $em->persist($product);
        $em->flush();

        return new Response('Created product id '.$product->getId());
    }

    /**
     * @Route("/create-blog", name="create-blog")
     */

    public function createBlogAction(Request $request)
    {
        $post = new Post();
        $post->setDescription('Nuevo post');
        $em = $this->getDoctrine()->getManager();
        $em->persist($post);
        $em->flush();
        return new Response('Created post id '.$post->getId());
    }

    /**
     * @Route("/create-category", name="create-category")
     */

    public function createCategoryAction(Request $request)
    {
        $post = new Category();
        $post->setName('Nueva Categoria');
        $em = $this->getDoctrine()->getManager();
        $em->persist($post);
        $em->flush();
        return new Response('Created category id '.$post->getId());
    }

}
