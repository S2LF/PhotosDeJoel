<?php

namespace App\Controller;

use App\Entity\Photo;
use App\Form\CatType;
use App\Form\PhotoType;
use App\Entity\PhotoCategorie;
use App\Repository\GeneralRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\PhotoCategorieRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/category")
 */
class PhotoController extends AbstractController
{
    /**
     * @Route("/", name="cats")
     */
    public function index(GeneralRepository $grepo, PhotoCategorieRepository $pcrepo)
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

        $cats =  $pcrepo->findAllOrderByPos();



        return $this->render('photo/index.html.twig', [
            'general' => $general,
            'cats' => $cats

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

