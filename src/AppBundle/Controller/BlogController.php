<?php
/**
 * Created by PhpStorm.
 * User: victor
 * Date: 20/01/16
 * Time: 03:44 PM
 */

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\Product;
use AppBundle\Entity\Task;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class BlogController  extends Controller
{
    public function listAction()
    {
        $posts = $this->get('doctrine')
            ->getManager()
            ->createQuery('SELECT p FROM AcmeBlogBundle:Post p')
            ->execute();

        return $this->render('AcmeBlogBundle:Blog:list.html.php', array('posts' => $posts));
    }

    /**
     * @Route("/login", name="loginGet")
     */

    public function loginAction()
    {   

        $data = array();

        return $this->render('AppBundle:blog:login.html.twig', array('data' => $data));
    }


    /**
     * @Route("/testblog", name="testblog")
     */

    public function testblogAction(Request $request)
    {   

        $data = array();

        // crea una task y le asigna algunos datos ficticios para este ejemplo
        $task = new Task();
        $task->setTask('Write a blog post');
        $task->setDueDate(new \DateTime('tomorrow'));
 
        $form = $this->createFormBuilder($task)
            ->add('task', TextType::class)
            ->add('dueDate', DateType::class)
            ->add('save', SubmitType::class, array('label' => 'Create Task'))
            ->add('saveAndAdd', SubmitType::class, array('label' => 'Save and Add'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // ... perform some action, such as saving the task to the database

            $nextAction = $form->get('saveAndAdd')->isClicked() ? 'task_new' : 'task_success';

            return $this->redirectToRoute($nextAction);
        }

        return $this->render('AppBundle:blog:testblog.html.twig', array(
            'data' => $data,
            'form' => $form->createView()
        ));
    }
}