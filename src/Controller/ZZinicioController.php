<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ZZinicioController extends AbstractController
{
    /**
     * @Route("homepage", name="homepage")
     */
    public function index(): Response
    {
        return $this->render('default/homepage.html.twig', [
            'controller_name' => 'ZZinicioController',
        ]);
    }
}
