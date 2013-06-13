<?php
namespace ad\UserBundle\Controller;

use Symfony\Component\HttpKernel\EventListener\RouterListener;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use ad\UserBundle\Form\UserType;
use ad\UserdBundle\Entity\User;
use JMS\SecurityExtraBundle\Annotation\Secure;
use FOS\UserBundle\Controller\ProfileController as FosUser;

class UserController extends FosUser
{

}