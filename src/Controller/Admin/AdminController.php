<?php

namespace App\Controller\Admin;



use App\Entity\General;
use App\Form\GeneralType;
use App\Service\FileUploader;
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
    public function index(GeneralRepository $grepo)
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

        return $this->render('admin/index.html.twig', [
            'general' => $general,
        ]);
    }

    /**
     * @Route("/general", name="admin_general")
     */
    public function general(Request $request, EntityManagerInterface $em, GeneralRepository $grepo, FileUploader $fileUploader){

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

        $generalForm = $grepo->findOneBy(['id' => 1]);
        if(!$generalForm){
            $generalForm = new General;
        }
        
        $form = $this->createForm(GeneralType::class, $generalForm);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            if($imageFile = $form->get("photo_accueil_path")->getData()){
                $newFilename = "home";
                $directory = "general";
                $imageFileName = $fileUploader->upload($imageFile, $newFilename, $directory);
                $generalForm->setPhotoAccueilPath($directory."/".$imageFileName);
            }

            $em->persist($generalForm);
            $em->flush();
            $this->addFlash("success", "Les informations ont bien été modifiés");
            return $this->redirectToRoute('admin');
        }

        return $this->render('admin/general.html.twig', [
            'general' => $general,
            "form" => $form->createView()
        ]);

    }


        

}