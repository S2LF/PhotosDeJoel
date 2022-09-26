<?php

namespace App\Controller;

use App\Repository\ExpoRepository;
use App\Repository\GeneralRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ExpoController extends AbstractController
{
    /**
     * @Route("/expo", name="expo")
     */
    public function index(GeneralRepository $grepo, ExpoRepository $exporepo): Response
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

        $expos =  $exporepo->findBy([], ['position' => 'ASC']);
        

        return $this->render('expo/index.html.twig', [
            'general' => $general,
            'expos' => $expos
        ]);
    }
}
