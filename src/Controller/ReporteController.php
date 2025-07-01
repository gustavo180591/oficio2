<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ReporteController extends AbstractController
{
    #[Route('/reportes', name: 'app_reportes')]
    public function index(): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        
        return $this->render('reporte/index.html.twig', [
            'controller_name' => 'ReporteController',
        ]);
    }
}
