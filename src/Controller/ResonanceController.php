<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use App\Entity\Tutorial;
# use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class ResonanceController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index( /*UserPasswordEncoderInterface $encoder */ )
    {
    	/*$em  = $this->getDoctrine()->getEntityManager();
    	$user = new User;
    	$encoded = $encoder->encodePassword($user, '111');
    	$user->setEmail('azeaze@hotmail.fr')
    	->setPassword($encoded)
    	->setRoles(array('ROLE_ADMIN'));
    	$em->persist($user);
    	$em->flush();*/
    	$em  = $this->getDoctrine();
    	$repo = $em->getRepository(Tutorial::class);
    	$tutorials = $repo->findBy([], ['PublishAt' => 'ASC']);

        return $this->render('resonance/index.html.twig', compact('tutorials'));
    }

    /**
     * @Route("tutoriel/{slug}", name="shop_tutoriel")
     */
    public function showTutorial($slug)
    {
    	$repo = $this->getDoctrine()->getRepository(Tutorial::class);
    	$tutorial = $repo->findOneBySlug($slug);
    	if(!$tutorial){
    		throw $this->createNotFoundException('Page inexistante ');
    	}
    	return $this->render('resonance/show.html.twig',compact('tutorial'));
    }
}
