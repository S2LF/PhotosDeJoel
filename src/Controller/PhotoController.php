<?php

namespace App\Controller;

use App\Entity\Photo;
use App\Form\CatType;
use App\Form\PhotoType;
use App\Entity\PhotoCategorie;
use App\Repository\GeneralRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/photo")
 */
class PhotoController extends AbstractController
{
    /**
     * @Route("/", name="photo")
     */
    public function index()
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



        return $this->render('photo/index.html.twig', [
            'controller_name' => 'PhotoController',
        ]);
    }

    /**
     * @Route("/{cat_id}", name="photo")
     */
    public function photo_cat()
    {
        return $this->render('photo/index.html.twig', [
            'controller_name' => 'PhotoController',
        ]);
    }

}

