<?php

namespace App\Controller;

use App\Entity\Sondage;
use App\Entity\QuestionLogique;
use App\Form\SondageType;
use App\Repository\SondageRepository;
use App\Repository\SujetRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SondageController extends AbstractController
{
   

    /**
     * @Route("/sondage_repondu",name="listeSondageRepondu")
     */
    public function listSondageRepondu(){
        $user = $this->getUser();
        $reponses=$user->getReponses();
        //$i=0;
        $sondages=[];
        if($reponses!= null){
            $i=0;
            $longeur=\count($reponses);
            while($i<$longeur){
                if($reponses[$i]->getQuestionLogique()!=null){
                    $sondage=$reponses[$i]->getQuestionLogique()->getSondage();
                    if($sondages==null){
                        array_push($sondages,$sondage);
                    }
                    else{
                        $j=0;
                        $longeur2=\count($sondages);
                        $test=false;
                        while($j<$longeur2){
                            if($sondages[$j]->getTitre()==$sondage->getTitre()){
                                $test=true;
                            }
                            $j++;
                        }
                        if($test==false){
                            array_push($sondages,$sondage);
                        }
                    }
                }
                else{
                    /** */
                    $sondage=$reponses[$i]->getQuestionMultiChoix()->getSondage();
                    if($sondages==null){
                        array_push($sondages,$sondage);
                    }
                    else{
                        $j=0;
                        $longeur2=\count($sondages);
                        $test=false;
                        while($j<$longeur2){
                            if($sondages[$j]->getTitre()==$sondage->getTitre()){
                                $test=true;
                            }
                            $j++;
                        }
                        if($test==false){
                            array_push($sondages,$sondage);
                        }
                    }
                }
                $i++;               
        }
        return $this->render('sondage/sondagerepondu.html.twig',['sondages'=>$sondages]);
    }
}



/**
     * @Route("/paiementConsulting",name="paiementConsulting")
     */
    public function login(){
        return $this->render("consulting\paiementConsulting.html.twig");
    }

   
 /**
     * @Route("/sondages",name="listesondage",methods="GET")
     */
    public function getSondages($id){
        $repo=$this->getDoctrine()->getRepository(Sondage::class);
        $sondages=$repo->findAll();
        
        
        foreach($sondages as $son)
        {    
            $em1=$this->getDoctrine()->getManager();
            $NbrSondage =count($em1->getRepository(Question::class)->findByNbrSondage($son->getId()));
            $son->setNbQuestion($NbrSondage );
            $em1->flush();
        }
 
        return $this->render('sondage/liste_sondage.html.twig',[
            'sondages'=>$sondages,
            'id'=>$id
            
        ]);
    }


    /**
     * @Route("/detailSondage", name="sondage_index", methods={"GET"})
     */
    public function index(SondageRepository $sondageRepository): Response
    {
        $enqueteur=$this->getUser();
        $sondages=$enqueteur->getSondages();
        foreach($sondages as $son)
        {    
            $em1=$this->getDoctrine()->getManager();
            $NbrQuestion =count($em1->getRepository(QuestionLogique::class)->findByNbrSondage($son->getId()));
            $son->setNbQuestion($NbrQuestion);
            $em1->flush();
        }
        
        return $this->render('sondage/index.html.twig', [
            'sondages' => $sondages,
            'idEnqueteur'=>$enqueteur->getId()
            ]);
    }
    
   

    /**
     * @Route("/new/{idEnqueteur}/{idSujet}", name="sondage_new", methods={"GET","POST"})
     */
    public function new($idEnqueteur, $idSujet,Request $request,SujetRepository $sujetRepository): Response
    {
        $sondage = new Sondage();
        $form = $this->createForm(SondageType::class, $sondage);
        $form->handleRequest($request);
        $sujet=$sujetRepository->find($idSujet);
        $enqueteur=$enqueteurRepository->find($idEnqueteur);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $sondage->setSujet($sujet);
            $sondage->setEnqueteur($enqueteur);
            $entityManager->persist($sondage);
            $entityManager->flush();

            return $this->redirectToRoute('consulting',['idSondage'=>$sondage->getId() , 
                                                        'idEnqueteur'=>$idEnqueteur ]);
        }

        return $this->render('sondage/new.html.twig', [
            'sondage' => $sondage,
            'idEnqueteur'=>$idEnqueteur,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/{id}", name="sondage_show", methods={"GET"})
     */
    public function show(Sondage $sondage): Response
    {
        return $this->render('sondage/show.html.twig', [
            'sondage' => $sondage,
            'idEnqueteur'=>$this->getUser()->getId()
        ]);
    }

    /**
     * @Route("/{id}/edit/{idEnqueteur}", name="sondage_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Sondage $sondage, $idEnqueteur): Response
    {
        $form = $this->createForm(SondageType::class, $sondage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('sondage_index',
                                            ['idEnqueteur'=> $idEnqueteur]);
        }

        return $this->render('sondage/edit.html.twig', [
            'sondage' => $sondage,
            'form' => $form->createView(),
            'idEnqueteur'=>$idEnqueteur
        ]);
    }

    /**
     * @Route("/{id}/{idEnqueteur}", name="sondage_delete", methods={"DELETE"})
     */
    public function delete($idEnqueteur,Request $request, Sondage $sondage): Response
    {
        if ($this->isCsrfTokenValid('delete'.$sondage->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($sondage);
            $entityManager->flush();
        }

        return $this->redirectToRoute('sondage_index',
                                      ['idEnqueteur'=> $idEnqueteur]);
    }
    /**
     * @Route("/sondagee/{id}",name="sondagee")
     * @param $id
     */
    public function getQuestion($id,SondageRepository $sondageRepository){

            $sondage=$sondageRepository->find($id);
            dd($sondage);

    }


    /**
     * @Route("consulting/{idEnqueteur}/{idSondage}", name="consulting", methods={"GET"})
     */
    public function consulting($idEnqueteur, $idSondage): Response
    {
        return $this->render('consulting/index.html.twig',['idSondage'=>$idSondage,
                                                            'idEnqueteur'=> $idEnqueteur]);
    }


}