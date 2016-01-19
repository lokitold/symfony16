<?php

namespace AppBundle\Controller;

use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UserController
{
    /**
     * @Rest\View
     */
    public function allAction()
    {
        $users = array('sds');
        var_dump($users);exit;

        return array('users' => $users);
    }

}