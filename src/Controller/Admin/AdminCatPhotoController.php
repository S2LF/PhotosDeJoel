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
class AdminCatPhotoController extends AbstractController
{
    /**
     * @Route("/addPhoto", name="admin_cat_photo")
     */
    public function index()
    {
        return $this->render('admin_cat_photo/index.html.twig', [
            'controller_name' => 'AdminCatPhotoController',
        ]);
    }


    /**
     * @Route("/cat", name="admin_categories")
     */
    public function AdminCategories(GeneralRepository $grepo, PhotoCategorieRepository $pcrepo)
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

        return $this->render('admin/cat.html.twig', [
            'general' => $general,
            'cats' => $cats

        ]);
    }


    
    /**
     * @Route("/cat/editCat/{id}", name="edit_cat")
     * @Route("/cat/addCat", name="add_cat")
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

        return $this->render('photo/addCat.html.twig', [
            'form' => $form->createView(),
            'general' => $general
        ]);
    }

    /**
     * @Route("/addPhoto", name="photo")
     */
    public function add_photo(Request $request)
    {

        // $photo = new Photo();

        // $form = $this->createForm(PhotoType::class, $photo);

        // $form->handleRequest($request);

        // if($form->isSubmitted() && $form->isValid()){
            
            // if($imageFile = $form->get("photo")->getData()){
            //     $imageFileName = $fileUploader->upload();
            // }

            // if(count($form->get('categories')->getData()) == 0){
            //     $this->addFlash("error", "Veuillez ajouter au moins une catégorie");
            //     return $this->render('photo/form.html.twig', [
            //         "form" => $form->createView()
            //     ]);
            // } else {
            //     /** @var UploadedFile $imageFile */
            //     $imageFile = $form->get('photo')->getData();
            //     // Rename file with SafeName + UniqId
            //     $safeFileName = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $photo->getTitle());
            //     $newFilename = $safeFileName.'-'.uniqid().'.'.$imageFile->guessExtension();

            //     // Move the file to the directory public/img
            //     try {
            //         $path = $photo->getUser()->getId();
            //         $imageFile->move(
            //             // img_directory is define in services.yaml
            //             $this->getParameter('img_directory').$path,
            //             $newFilename
            //         );
            //         $photo->setPath($path."/".$newFilename);
            //     } catch( FileException $e) {
            //         $this->addFlash("error", "Une problème est survenu lors de l'upload de l'image");
            //     }
            //     $photo->setDateCreation(new \Datetime('now', new \DateTimeZone('Europe/Paris')  ));

        //         $em->persist($photo);
        //         $em->flush();
        //         $this->addFlash("success", "La photo a bien été ajouté, merci !");
        //     }

        // return $this->redirectToRoute('user_photos', array('id' => $photo->getUser()->getId()) );
        }
}