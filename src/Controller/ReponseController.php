<?php

namespace App\Controller;

use App\Entity\Sondage;
use App\Entity\Option;
use App\Entity\Question;
use App\Form\SondageType;
use App\Repository\SondageRepository;
use App\Repository\ReponseRepository;
use App\Repository\QuestionRepository;
use App\Repository\SujetRepository;
use App\Repository\EnqueteurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/Reponse")
 */
class ReponseController extends AbstractController
{
    /**
     * @Route("/Repondre/{idSondage} ",name="repondre",methods="GET")
     */
    public function Repondre( $idSondage){
        $repo1=$this->getDoctrine()->getRepository(Question::class);
        $Questions=$repo1->findByNbrSondage($idSondage);
        
        
        foreach($Questions as $question)
        {    
            $repo2=$this->getDoctrine()->getRepository(Option::class);
            $Options=$repo2->findByIdQuestion($question->getId());
        }
 
        return $this->render('sondage/repondre.html.twig',[
            'Questions'=>$Questions,
            'Options'=>$Options,
            'idSondage'=>$idSondage
        ]);
    }
/**
     * @Route("/Repondre/{id}/{idSondage} ",name="RecupererReponse",methods="POST")
     */
    public function RecupererReponse($id, $idSondage){
        $repo1=$this->getDoctrine()->getRepository(Question::class);        
        $Questions=$repo1->findByNbrSondage($idSondage);        
        $tab = array();
        
         
        foreach($Questions as $question)
        {  
            array_push($tab,$_POST[$question->getId()]);
        }

        return $this->redirectToRoute('listesondage',[ 'idSonde'=>$id]);
       /* return $this->render('accueil.html.twig',
                            [ 'id'=>$id,                                        
                            'post'=>$tab,                                        
                            'idSondage'=>$idSondage]);*/
        
        
    }


    


}
