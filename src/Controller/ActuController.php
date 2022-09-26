<?php

namespace App\Controller;

use App\Repository\ActualiteRepository;
use App\Repository\GeneralRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ActuController extends AbstractController
{
    /**
     * @Route("/actu", name="actu")
     */
    public function index(GeneralRepository $grepo, ActualiteRepository $acturepo): Response
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

        $actus =  $acturepo->findBy([], ['position' => 'ASC']);

        return $this->render('actu/index.html.twig', [
            'general' => $general,
            'actus' => $actus
        ]);
    }
}
