<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\Post;
use AppBundle\Entity\Category;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class TestFormController extends Controller
{

    /**
     * @Route("/test-form", name="test-form")
     */

    public function newAction(Request $request)
    {
        // create a task and give it some dummy data for this example
        $category = new Category();
        $category->setName('Write a blog post');

        $form = $this->createFormBuilder($category)
            ->add('name', TextType::class)
            ->add('save', SubmitType::class, array('label' => 'Create Category'))
            ->getForm();

        return $this->render('AppBundle:test-form:new.html.twig', array(
            'form' => $form->createView(),
        ));
    }

}
