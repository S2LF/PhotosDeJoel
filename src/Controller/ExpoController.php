<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ExpoController extends AbstractController
{
    /**
     * @Route("/expo", name="expo")
     */
    public function index(): Response
    {
        return $this->render('expo/index.html.twig', [
            'controller_name' => 'ExpoController',
        ]);
    }
}
