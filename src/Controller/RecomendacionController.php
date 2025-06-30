<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request; // Importación correcta
use Doctrine\ORM\EntityManagerInterface; // Correcto
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Recomendacion;


class RecomendacionController extends AbstractController
{
    #[Route('/crear-recomendacion', name: 'crear_recomendacion', methods: ['POST'])]
    public function crear(Request $request, EntityManagerInterface $em): Response
    {
        // Obtener el texto del formulario
        $text = $request->request->get('recomendacionText');

        if ($text) {
            // Crear una nueva recomendación
            $recomendacion = new Recomendacion();
            $recomendacion->setText($text);
            $recomendacion->setDate(new \DateTime());

            // Guardar en la base de datos
            $em->persist($recomendacion);
            $em->flush();

            // Añadir mensaje flash o redirigir a una página de éxito
            $this->addFlash('success', 'Recomendación creada con éxito.');
        }

        // Redirigir o mostrar un mensaje
        return $this->render('oficio/success.html.twig');
    }
}
