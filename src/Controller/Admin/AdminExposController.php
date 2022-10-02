<?php

namespace App\Controller\Admin;

use App\Controller\GeneralController;
use App\Entity\Expo;
use App\Form\ExpoType;
use App\Service\FileUploader;
use App\Repository\ExpoRepository;
use App\Repository\GeneralRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/admin")
 */
class AdminExposController extends GeneralController
{
  /**
   * @Route("/expos", name="admin_expos")
   */
  public function index(GeneralRepository $grepo, ExpoRepository $erepo)
  {
    $expos = $erepo->findAllOrderByPos();

    return $this->render('admin/expos/index.html.twig', [
      'general' => $this->general,
      'expos' => $expos
    ]);
  }

  /**
   * @Route("/expos/add", name="admin_expo_add")
   * @Route("/expos/edit/{id}", name="admin_expo_edit")
   */
  public function formCat(Expo $expo = null, Request $request, EntityManagerInterface $em, FileUploader $fileUploader)
  {
    if (!$expo) {
      $expo = new Expo;
    }

    $form = $this->createForm(ExpoType::class, $expo);

    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {

      $expo->setDateCreation(new \DateTime('now', new \DateTimeZone('Europe/Paris')));

      if ($imageFile = $form->get("path")->getData()) {
        $newFilename = $expo->getTitre();
      }

      $em->persist($expo);
      $em->flush();

      if ($imageFile = $form->get("path")->getData()) {
        $id = $expo->getId();
        $directory = "/expo/" . $id;
        $imageFileName = $fileUploader->upload($imageFile, $newFilename, $directory);
        $expo->setPath($directory . "/" . $imageFileName);

        $em->persist($expo);
        $em->flush();
      }
      $this->addFlash("success", "L'exposition a bien été ajouté/modifié");
      return $this->redirectToRoute('admin_expos');
    }

    return $this->render('admin/expos/addExpo.html.twig', [
      'form' => $form->createView(),
      'general' => $this->general,
    ]);
  }

  /**
   * @Route("/expo/sort", name="admin_expo_sort")
   */
  public function sortableExpo(Request $request, EntityManagerInterface $em, ExpoRepository $erepo)
  {
    $expo_id = $request->request->get('expo_id');
    $position = $request->request->get('position');

    $expo = $erepo->findOneBy(['id' => $expo_id]);

    $expo->setPosition($position);

    try {
      $em->flush();
      return new Response(true);
    } catch (\PdoException $e) {
    }
  }
}
