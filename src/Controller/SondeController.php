<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\User;
use App\Form\UserType;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SondeController extends AbstractController
{
    /**
     * @Route("/sonde", name="sonde")
     */
    public function index(): Response
    {
        return $this->render('sonde/index.html.twig', [
            'controller_name' => 'SondeController',
        ]);
    }

    /**
     * @Route("/inscriptionSonde",name="addsonde")
     */
    public function addAdmin(UserPasswordEncoderInterface $encoder,Request $req){

        $admin=new User();
        $form = $this->createForm(UserType::class, $admin);
        $form->handleRequest($req);
        if ($form->isSubmitted() && $form->isValid()) {
            $encoded = $encoder->encodePassword($admin, $admin->getPassword());
            $manager = $this->getDoctrine()->getManager();
            $admin->setRoles(["Sonde"]);
            $admin->setPassword($encoded);
            $manager->persist($admin);
            $manager->flush();
            return $this->redirectToRoute('accueil');
        }
            return $this->render('sonde/inscription.html.twig', [
                'form' => $form->createView()
                
            ]);
    }
    

    /**
     * @Route("/accueilSonde", name="accueilsonde")
     */
    public function accueilSonde(): Response
    {
        return $this->render('sonde/accueil_sonde.html.twig');
    }


     /**
     * @Route("/", name="accueil")
     */
    public function accueil(): Response
    {
        return $this->render('accueil.html.twig');
    }


}
