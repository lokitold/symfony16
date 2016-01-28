<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\Post;
use AppBundle\Entity\Category;

class TestDoctrineController extends Controller
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

    /**
     * @Route("/blog/show/{id}", name="blogshow")
     */

    public function showAction($id)
    {
        $post = $this->getDoctrine()
            ->getRepository('AppBundle:Post')
            ->find($id);

        if (!$post) {
            throw $this->createNotFoundException(
                'No post found for id '.$id
            );
        }

        echo "<pre>";
        print_r($post);
        echo "</pre>";exit;

        // ... do something, like pass the $product object into a template
    }

    /**
     * @Route("/test-repository", name="test-repository")
     */

    public function testRepositoryAction(Request $request)
    {
        $repository = $this->getDoctrine()
            ->getRepository('AppBundle:Post');

        $post = $repository->findAll();
        echo "<pre>";
        print_r($post);
        echo "</pre>";exit;

    }

    /**
     * @Route("/product/update/{id}", name="blogshow")
     */

    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $product = $em->getRepository('AppBundle:Product')->find($id);

        if (!$product) {
            throw $this->createNotFoundException(
                'No product found for id '.$id
            );
        }

        $product->setName('New product name!');
        $em->flush();

        return new Response('Update product id '.$product->getId());
    }

    /**
     * @Route("/test-query-raw", name="test-query-raw")
     */

    public function testQueryRawAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery(
            'SELECT p
    FROM AppBundle:Product p
    WHERE p.price > :price
    ORDER BY p.price ASC'
        )->setParameter('price', '19.00');

        $products = $query->getResult();

        echo "<pre>";
        print_r($products);
        echo "</pre>";exit;

    }

    /**
     * @Route("/test-doctrine-repository", name="test-doctrine-repository")
     */

    public function testQueryDoctrineRepository (){
        $em = $this->getDoctrine()->getManager();
        $products = $em->getRepository('AppBundle:Product')
            ->findAllOrderedByName();
        echo "<pre>";
        print_r($products);
        echo "</pre>";exit;
    }


}
