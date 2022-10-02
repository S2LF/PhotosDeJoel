<?php

namespace App\Controller\Admin;

use App\Controller\GeneralController;
use App\Entity\Lien;
use App\Form\LienType;
use App\Repository\LienRepository;
use App\Repository\GeneralRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin")
 */
class AdminLiensController extends GeneralController
{
    /**
     * @Route("/lien", name="admin_lien")
     */
    public function index(LienRepository $lrepo)
    {
        $liens = $lrepo->findAllOrderByPos();

        return $this->render('admin/liens/index.html.twig', [
            'general' => $this->general,
            'liens' => $liens
        ]);
    }

    /**
     * @Route("/lien/add", name="admin_lien_add")
     * @Route("/lien/edit/{id}", name="admin_lien_edit")
     */
    public function formCat(Lien $lien = null, Request $request, EntityManagerInterface $em){
        if(!$lien){
        $lien = new Lien;           
        }

        $form = $this->createForm(LienType::class, $lien);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $em->persist($lien);
            $em->flush();
            $this->addFlash("success", "Le lien a bien été ajouté/modifié");
            return $this->redirectToRoute('admin_lien');
        }

    return $this->render('admin/liens/addLien.html.twig', [
            'form' => $form->createView(),
            'general' => $this->general,
        ]);

    }

    /**
     * @Route("/lien/sort", name="admin_lien_sort")
     */
    public function sortableLien(Request $request, EntityManagerInterface $em, LienRepository $lrepo){

        $lien_id = $request->request->get('lien_id');
        $position = $request->request->get('position');

        $lien = $lrepo->findOneBy(['id' => $lien_id ]);
        
        $lien->setPosition($position);

        try{
            $em->flush();
            return new Response(true);
        }catch(\PdoException $e){

        }
    }

}