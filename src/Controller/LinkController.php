<?php

namespace App\Controller;

use App\Repository\GeneralRepository;
use App\Repository\LienRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LinkController extends AbstractController
{
    /**
     * @Route("/liens", name="links")
     */
    public function index(GeneralRepository $grepo, LienRepository $lienrepo): Response
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

        $links =  $lienrepo->findBy([], ['position' => 'ASC']);

        return $this->render('link/index.html.twig', [
            'general' => $general,
            'links' => $links
        ]);
    }
}
