<?php

namespace App\Controller;

use App\Entity\Option;
use App\Entity\Sondage;
use App\Form\SondageType;
use App\Repository\SondageRepository;
use App\Entity\QuestionLogique;
use App\Form\QuestionType;
use App\Repository\QuestionLogiqueRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
class BlogController extends AbstractController
{
    /**
     * @Route("/creer/{id}", name="creersondage", methods={"GET","POST"})
     * @param SondageRepository $sondageRepository
     * @param QuestionLogiqueRepository $questionRepository
     * @return Response
     */
    public function index($id, SondageRepository $sondageRepository, QuestionLogiqueRepository $questionRepository): Response
    {
        return $this->render('sondage/creersondage.html.twig', [
            'sondage' => $sondageRepository->find($id),


        ]);
    }

    /**
     * @Route("/sondageBlog", name="sondageBlog", methods={"GET"})
     * @param SondageRepository $sondageRepository
     * @param QuestionLogiqueRepository $questionRepository
     * @return Response
     */
    public function sondage(SondageRepository $sondageRepository, QuestionLogiqueRepository $questionRepository): Response
    {
        return $this->render('blog/sondage.html.twig', [
            'sondages' => $sondageRepository->findAll(),


        ]);
    }

    /**
     * @Route("/affichersondage/{id}", name="affichersondage", methods={"GET"})
     * @param SondageRepository $sondageRepository
     * @param QuestionLogiqueRepository $questionRepository
     * @return Response
     */
    public function affichersondage($id,SondageRepository $sondageRepository, QuestionLogiqueRepository $questionRepository): Response
    {

        return $this->render('sondage/ajouter.html.twig', [
            'sondagess' => $sondageRepository->find($id),


        ]);
    }
    /**
     * @Route("/nvl", name="nvl", methods={"GET"})
     */
    public function nvl(): Response
    {
        return $this->render('blog/creersondage.html.twig');
    }

    /**
     * @Route("/neww/{idSondage}/{idEnqueteur}", name="neww")
     * @param Request $request
     * @return \symfony\Component\HttpFoundation\Response
     */
public function new(Request $request,$idSondage, $idEnqueteur, SondageRepository $sondageRepository):Response{
    $question = new QuestionLogique();


    $form=$this->createForm(QuestionType::class,$question);
    $form->handleRequest($request);

    $sondage=$sondageRepository->find($idSondage);

    if ($form->isSubmitted()&& $form->isValid() ) {
        $em= $this->getDoctrine()->getManager();

        $question->setSondage($sondage);
        $em->persist($question);


        $em->flush();
        return $this->render('question/neww.html.twig',[
            'sondage' => $sondage,
            'question'=>$question,
            'idEnqueteur'=>$idEnqueteur,
            'form' => $form->createView(),
        ]);

    }
    return $this->render('question/neww.html.twig',[
        'sondage' => $sondage,
        'question'=>$question,
        'idEnqueteur'=>$idEnqueteur,
        'form' => $form->createView(),
    ]);



    }


}
