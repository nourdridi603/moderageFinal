<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\User;
use App\Form\EnqueteurType;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class EnqueteurController extends AbstractController
{
    /**
     * @Route("/enqueteur", name="enqueteur")
     */
    public function index(): Response
    {
        return $this->render('enqueteur/index.html.twig', [
            'controller_name' => 'EnqueteurController',
        ]);
    }


    /**
     * @Route("/inscriptionEnqueteur",name="addEnqueteur")
     */
    public function addEnqueteur(UserPasswordEncoderInterface $encoder,Request $req){

        $admin=new User();
        $form = $this->createForm(EnqueteurType::class, $admin);
        $form->handleRequest($req);
        if ($form->isSubmitted() && $form->isValid()) {
            $encoded = $encoder->encodePassword($admin, $admin->getPassword());
            $manager = $this->getDoctrine()->getManager();
            $admin->setRoles(["Enqueteur"]);
            $admin->setPassword($encoded);
            $manager->persist($admin);
            $manager->flush();
        }
            return $this->render('enqueteur/inscription.html.twig', [
                'form' => $form->createView()
                
            ]);
    }

     /**
     * @Route("/accueilEnqueteur", name="accueilEnqueteur")
     */
    public function accueilEnqueteur(): Response
    {
        return $this->render('Enqueteur\accueil_enqueteur.html.twig');
    }
}
