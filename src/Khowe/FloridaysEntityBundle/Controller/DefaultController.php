<?php

namespace Khowe\FloridaysEntityBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('FloridaysEntityBundle:Default:index.html.twig', array('name' => $name));
    }
}
