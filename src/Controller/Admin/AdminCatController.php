<?php

namespace App\Controller\Admin;

use App\Form\CatType;
use App\Service\FileUploader;
use App\Entity\PhotoCategorie;
use App\Repository\PhotoRepository;
use App\Repository\GeneralRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\PhotoCategorieRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/admin")
 */
class AdminCatController extends AbstractController
{

    /**
     * @Route("/cat", name="admin_categories")
     */
    public function Index(GeneralRepository $grepo, PhotoCategorieRepository $pcrepo, PhotoRepository $prepo)
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

        // $cats = $pcrepo->findAll();
        $cats = $pcrepo->findAllOrderByPos();

        return $this->render('admin/cats/index.html.twig', [
            'general' => $general,
            'cats' => $cats,
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

        if($imageFile = $form->get("path")->getData()){
            $newFilename = $cat->getTitre();
        }

        if($form->isSubmitted() && $form->isValid()){
            if($imageFile = $form->get("path")->getData()){
                $id = $cat->getId();
                $directory = "/photo/".$id."/cover";
                $imageFileName = $fileUploader->upload($imageFile, $newFilename, $directory);
                $cat->setPhotoCoverPath($directory."/".$imageFileName);
    
            }
            $em->persist($cat);
            $em->flush();

            $this->addFlash("success", "La catégorie a bien été crée/modifié");
            return $this->redirectToRoute('admin_categories');
        }

        return $this->render('admin/cats/addCat.html.twig', [
            'form' => $form->createView(),
            'general' => $general,
            'cat' => $cat
        ]);
    }

    /**
     * @Route("/cat/sort", name="admin_cat_sort")
     */
    public function sortableCat(Request $request, EntityManagerInterface $em, PhotoCategorieRepository $lrepo){

        $cat_id = $request->request->get('cat_id');
        $position = $request->request->get('position');

        $cat = $lrepo->findOneBy(['id' => $cat_id ]);
        
        $cat->setPosition($position);

        try{
            $em->flush();
            return new Response(true);
        }catch(\PdoException $e){

        }
    }

    public function deleteCat(){} // TODO

    // /**
    //  * @Route("/cats/sort", name="admin_cat_sort")
    //  */
    // public function sortableCat(Request $request, EntityManagerInterface $em, PhotoCategorieRepository $pcrepo){

    //     $cat_id = $request->request->get('cat_id');
    //     $position = $request->request->get('position');

    //     $cat = $pcrepo->findOneBy(['id' => $cat_id ]);
        
    //     $cat->setPosition($position);

    //     try{
    //         $em->flush();
    //         return new Response(true);
    //     }catch(\PdoException $e){

    //     }
    // }
}