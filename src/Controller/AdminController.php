<?php

namespace App\Controller;


use App\Entity\General;
use App\Form\GeneralType;
use App\Repository\GeneralRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

    /**
     * @Route("/admin")
     */
class AdminController extends AbstractController
{
    /**
     * @Route("/", name="admin")
     */
    public function index()
    {
        return $this->render('admin/index.html.twig', [

        ]);
    }

    /**
     * @Route("/general", name="general")
     */
    public function general(Request $request, EntityManagerInterface $em, GeneralRepository $grepo){

        $general = $grepo->findOneBy(['id' => 1]);
        if(!$general){
            $general = new General;
        }
        
        $form = $this->createForm(GeneralType::class, $general);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $em->persist($general);
            $em->flush();
            $this->addFlash("success", "Les informations ont bien été modifiés");
            return $this->redirectToRoute('admin');
        }

        return $this->render('admin/general.html.twig', [
            "form" => $form->createView()
        ]);

    }
}