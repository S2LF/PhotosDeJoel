<?php

namespace App\Controller\Admin;

use App\Entity\Expo;
use App\Form\ExpoType;
use App\Repository\ExpoRepository;
use App\Repository\GeneralRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/admin")
 */
class AdminExposController extends AbstractController
{
    /**
     * @Route("/expos", name="admin_expos")
     */
    public function index(GeneralRepository $grepo, ExpoRepository $erepo)
    {
        $general = $grepo->findOneBy(['id' => 1]);
        if($general == null){
            $general = [
                "titreDuSiteHeader" => "Titre par défaut",
                "texteHeader" => "Texte à écrire par défaut",
                "motPageAccueil" => "Mot page d'accueil par défaut",
                "photoAccueilPath" => null,
                "textFooter" => "texte pied de page par défaut"
            ];
        }

        $expos = $erepo->findAllOrderByPos();

        return $this->render('admin/expos/index.html.twig', [
            'general' => $general,
            'expos' => $expos
        ]);
    }

    /**
     * @Route("/expos/add", name="admin_expo_add")
     * @Route("/expos/edit/{id}", name="admin_expo_edit")
     */
    public function formCat(GeneralRepository $grepo, Expo $expo = null, Request $request, EntityManagerInterface $em){

        $general = $grepo->findOneBy(['id' => 1]);
        if($general == null){
            $general = [
                "titreDuSiteHeader" => "Titre par défaut",
                "texteHeader" => "Texte à écrire par défaut",
                "motPageAccueil" => "Mot page d'accueil par défaut",
                "photoAccueilPath" => null,
                "textFooter" => "texte pied de page par défaut"
            ];
        }

        if(!$expo){
        $expo = new Expo;           
        }

        $form = $this->createForm(ExpoType::class, $expo);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $expo->setDateCreation(new \DateTime('now', new \DateTimeZone('Europe/Paris')));

            $em->persist($expo);
            $em->flush();
            $this->addFlash("success", "L'exposition a bien été ajouté/modifié");
            return $this->redirectToRoute('admin_expos');
        }

    return $this->render('admin/expos/addExpo.html.twig', [
            'form' => $form->createView(),
            'general' => $general,
        ]);

    }

    /**
     * @Route("/expo/sort", name="admin_expo_sort")
     */
    public function sortableExpo(Request $request, EntityManagerInterface $em, ExpoRepository $erepo){

        $expo_id = $request->request->get('expo_id');
        $position = $request->request->get('position');

        $expo = $erepo->findOneBy(['id' => $expo_id ]);
        
        $expo->setPosition($position);

        try{
            $em->flush();
            return new Response(true);
        }catch(\PdoException $e){

        }
    }
}
