<?php

namespace App\Controller\Admin;

use App\Form\ActuType;
use App\Entity\Actualite;
use App\Service\FileUploader;
use App\Repository\GeneralRepository;
use App\Repository\ActualiteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/admin")
 */
class AdminActuController extends AbstractController
{
    /**
     * @Route("/actu", name="admin_actu")
     */
    public function index(GeneralRepository $grepo, ActualiteRepository $arepo)
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

        // $actus = $arepo->findAll();
        $actus = $arepo->findAllOrderByPos();


        return $this->render('admin/actu/index.html.twig', [
            'general' => $general,
            'actus' => $actus
        ]);
    }

    /**
     * @Route("/actu/add", name="admin_actu_add")
     * @Route("/actu/edit/{id}", name="admin_actu_edit")
     */
    public function formCat(GeneralRepository $grepo, Actualite $actu = null, Request $request, EntityManagerInterface $em, FileUploader $fileUploader){

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

        if(!$actu){
        $actu = new Actualite;           
        }

        $form = $this->createForm(ActuType::class, $actu);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $actu->setDateCreation(new \DateTime('now', new \DateTimeZone('Europe/Paris')));

            if($imageFile = $form->get("path")->getData()){
                $newFilename = $actu->getTitre();
            }

            $em->persist($actu);
            $em->flush();

            if($imageFile = $form->get("path")->getData()){
                $id = $actu->getId();
                $directory = "/actu/".$id;
                $imageFileName = $fileUploader->upload($imageFile, $newFilename, $directory);
                $actu->setPath($directory."/".$imageFileName);

                $em->persist($actu);
                $em->flush();
            }

            $this->addFlash("success", "L'article d'actualité a bien été ajouté/modifié");
            return $this->redirectToRoute('admin_actu');
        }

    return $this->render('admin/actu/addActu.html.twig', [
            'form' => $form->createView(),
            'general' => $general,
        ]);

    }

    /**
     * @Route("/actu/sort", name="admin_actu_sort")
     */
    public function sortableActu(Request $request, EntityManagerInterface $em, ActualiteRepository $arepo){

        $actu_id = $request->request->get('actu_id');
        $position = $request->request->get('position');

        $actu = $arepo->findOneBy(['id' => $actu_id ]);
        
        $actu->setPosition($position);

        try{
            $em->flush();
            return new Response(true);
        }catch(\PdoException $e){

        }
    }

}
