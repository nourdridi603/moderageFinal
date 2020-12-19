<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\CadeauType ;
use App\Form\NewRemunerationType ;
use App\Form\RemiseType ;
use App\Entity\Cadeau;
use App\Entity\Remise;
use App\Entity\NouveauType;
use App\Repository\RemunerationRepository;



class RemunerationController extends AbstractController
{

    private $em;
    public function __construct ( EntityManagerInterface $em){
        $this->em=$em;
    }
    

    public function index(): Response
    {
        return $this->render('Remuneration/ChoixRemun.html.twig', [
            'controller_name' => 'RemunerationController',
        ]);
    }
     /**
     * @Route("/ChoixRemun", name="ChoixRemun")
     */
      public function ChoixRemun( Request $request){
        
            $cadeau=new Cadeau();
            $form= $this->createForm(CadeauType::class, $cadeau);
            $form->handleRequest($request);
    
            if ($form->isSubmitted() && $form->isValid()){
            $this->em->persist($cadeau);
            $this->em->flush();
            return $this->redirectToRoute("ChoixRemun");
            }
               
            $remise=new Remise();
            $form1= $this->createForm(RemiseType::class, $remise);
            $form1->handleRequest($request);
         
            if ($form1->isSubmitted() && $form1->isValid()){
               $this->em->persist($remise);
               $this->em->flush();
               return $this->redirectToRoute("ChoixRemun");
            }
            return $this->render('Remuneration/ChoixRemun.html.twig',[
                'remise'=>$remise,
                'cadeau'=>$cadeau,
                'form1'=>$form1->createView(),
                'form'=>$form->createView()
                    
                ]);
            }
    /**
     * @Route("/AjoutRemun", name="AjoutRemun")
     */
        public function AddRemun( Request $request){
                   
                $remun=new NouveauType();
                $form= $this->createForm(NewRemunerationType::class, $remun);
                $form->handleRequest($request);
             
                if ($form->isSubmitted() && $form->isValid()){
                   $this->em->persist($remun);
                   $this->em->flush();
                   return $this->redirectToRoute("AjoutRemun");
                }
                return $this->render('Remuneration/AjoutRemun.html.twig',[
                    'remuneration'=>$remun,
                    'form'=>$form->createView()]);
                }
                      
              
        }
