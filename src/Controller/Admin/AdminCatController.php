<?php

namespace App\Controller\Admin;

use App\Form\CatType;
use App\Service\FileUploader;
use App\Entity\PhotoCategorie;
use App\Repository\GeneralRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\PhotoCategorieRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/admin")
 */
class AdminCatController extends AbstractController
{



    /**
     * @Route("/cat_add", name="admin_categories")
     */
    public function Index(GeneralRepository $grepo, PhotoCategorieRepository $pcrepo)
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

        $cats = $pcrepo->findAll();

        return $this->render('admin/cats/index.html.twig', [
            'general' => $general,
            'cats' => $cats

        ]);
    }


    
    /**
     * @Route("/cat/editCat/{id}", name="admin_edit_cat")
     * @Route("/cat/addCat", name="admin_add_cat")
     */
    public function add_cat(PhotoCategorie $cat = null, GeneralRepository $grepo, Request $request, EntityManagerInterface $em, FileUploader $fileUploader)
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

        if(!$cat){
            $cat = new PhotoCategorie;
        }

        $form = $this->createForm(CatType::class, $cat);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            if($imageFile = $form->get("photo_cover_path")->getData()){
                $newFilename = $cat->getTitre();
                $directory = "/photo/".$cat->getTitre()."/cover";
                $imageFileName = $fileUploader->upload($imageFile, $newFilename, $directory);
                $cat->setPhotoCoverPath($directory."/".$imageFileName);
            }

            $em->persist($cat);
            $em->flush();
            $this->addFlash("success", "La catégorie ont bien été crée/modifié");
            return $this->redirectToRoute('admin_categories');
        }

        return $this->render('admin/cats/addCat.html.twig', [
            'form' => $form->createView(),
            'general' => $general,
            'cat' => $cat
        ]);
    }

    public function deleteCat(){} // TODO

}