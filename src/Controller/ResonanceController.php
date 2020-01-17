<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\TutorialRepository;
use App\Repository\CategoryRepository;
use App\Entity\User;
use App\Entity\Tutorial;
use App\Entity\Category;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Contracts\Cache\CacheInterface;

class ResonanceController extends AbstractController
{
   /* private $encoder ;

    public function __construct(UserPasswordEncoderInterface $encoder){
        $this->encoder = $encoder ;
    }*/
    
    /**
     * @Route("/", name="home")
     */
    public function index( Security $security , TutorialRepository $RepoTutorial , CategoryRepository $RepoCategory)
    {

        $CurrentUser = $security->getUser();
        $IdBasique = $RepoCategory->findOneBy(["Name" => "Basique"]);
        $IdAdvanced = $RepoCategory->findOneBy(["Name" => "Avancé"]);
        $tutorialsBasique = $RepoTutorial->findBy(["isPublish" => true, "category" => $IdBasique], ['order_menu' => 'ASC']);
    	$tutorialsAdvanced = $RepoTutorial->findBy(["isPublish" => true, "category" => $IdAdvanced], ['order_menu' => 'ASC']);

        return $this->render('resonance/index.html.twig', compact('tutorialsBasique','tutorialsAdvanced','CurrentUser'));
    }

    /**
     * @Route("tutoriel/{slug}", name="show_tutoriel")
     */
    public function showTutorial($slug, TutorialRepository $repo,CacheInterface $cache)
    {

        # $this->denyAccessUnlessGranted('ROLE_USER');
     
    	$tutorial = $repo->findOneBySlug($slug);

        $ActualOrder = $cache->get($keyTutorial = "tutorial_".md5($tutorial->getContent());, function($item) use ($tutorial){
            $ActualOrder = $tutorial->getOrderMenu();
            return $ActualOrder;
        });
        
        $NextTutorial = $repo->findOneNextTuto($ActualOrder);
        
        $PrevTutorial = $repo->findOnePrevTuto($ActualOrder);

    	if(!$tutorial){
    		throw $this->createNotFoundException('Page inexistante ');
    	}
    	return $this->render('resonance/show.html.twig',compact('tutorial','NextTutorial','PrevTutorial'));
    }



    /* 
     Morceau de code pour inscription d'utilisateur avec injection de dépendance
         $em  = $this->getDoctrine()->getEntityManager();
        $user = new User;
        $encoded = $this->encoder->encodePassword($user, '111');
        $user->setEmail('azeaze@hotmail.fr')
        ->setPassword($encoded)
        ->setInscription(new \Datetime('now'))
        ->setRoles(array('ROLE_ADMIN'));
        $em->persist($user);
        $em->flush();
     */
}
