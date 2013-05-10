<?php

namespace ad\BuyBoatBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('adBuyBoatBundle:Default:index.html.twig', array('name' => $name));
    }
}
