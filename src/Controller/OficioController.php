<?php

namespace App\Controller;

use App\Entity\Oficio;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;

class OficioController extends AbstractController
{
        #[Route('/', name: 'app_oficio', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('oficio/index.html.twig', [
            'controller_name' => 'OficioController',
        ]);
    }
    
    #[Route('/oficio/nuevo', name: 'app_oficio_nuevo', methods: ['POST'])]
    public function nuevo(Request $request, EntityManagerInterface $em): Response
    {
        // Obtener el texto del formulario
        $name = $request->request->get('nombreOficio');

        if ($name) {
            // Crear una nueva recomendación
            $recomendacion = new Oficio();
            $recomendacion->setName($name);
            $recomendacion->setStatus(true);

            // Guardar en la base de datos
            $em->persist($recomendacion);
            $em->flush();

            // Añadir mensaje flash o redirigir a una página de éxito
            $this->addFlash('success', 'Recomendación creada con éxito.');
        }

        // Redirigir o mostrar un mensaje
        return $this->redirectToRoute('app_full_list');
    }
    #[Route('/oficio/{id}/toggle-status', name: 'oficio_toggle_status', methods: ['POST'])]
    public function toggleStatus($id, Request $request, EntityManagerInterface $em, CsrfTokenManagerInterface $csrfTokenManager): JsonResponse
    {
        try {
            // Get the request data
            $data = json_decode($request->getContent(), true);
            
            if (json_last_error() !== JSON_ERROR_NONE) {
                $data = $request->request->all();
            }
            
            // Verify CSRF token from request data
            if (!isset($data['_token']) || !$csrfTokenManager->isTokenValid(new CsrfToken('oficio_toggle', $data['_token']))) {
                return new JsonResponse(['success' => false, 'error' => 'Token CSRF inválido'], 403);
            }

            // Find the oficio
            $oficio = $em->getRepository(Oficio::class)->find($id);
            if (!$oficio) {
                return new JsonResponse(['success' => false, 'error' => 'Oficio no encontrado'], 404);
            }

            // Validate status
            if (!isset($data['status'])) {
                return new JsonResponse(['success' => false, 'error' => 'Estado no proporcionado'], 400);
            }

            // Update status
            $newStatus = (bool)$data['status'];
            $oficio->setStatus($newStatus);
            $em->persist($oficio);
            $em->flush();

            return new JsonResponse([
                'success' => true,
                'status' => $oficio->isStatus(),
                'message' => 'Estado actualizado correctamente',
                'newStatus' => $oficio->isStatus() ? '1' : '0'
            ]);
            
        } catch (\Exception $e) {
            return new JsonResponse([
                'success' => false,
                'error' => 'Error al actualizar el estado',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    #[Route('/oficio/{id}/delete', name: 'oficio_delete', methods: ['DELETE'])]
    public function delete($id, Request $request, EntityManagerInterface $em, CsrfTokenManagerInterface $csrfTokenManager): JsonResponse
    {
        try {
            // Get the request data
            $data = json_decode($request->getContent(), true);
            
            // Verify CSRF token from request data
            if (!isset($data['_token']) || !$csrfTokenManager->isTokenValid(new CsrfToken('oficio_delete', $data['_token']))) {
                return new JsonResponse(['success' => false, 'error' => 'Token CSRF inválido'], 403);
            }

            // Find the oficio
            $oficio = $em->getRepository(Oficio::class)->find($id);
            if (!$oficio) {
                return new JsonResponse(['success' => false, 'error' => 'Oficio no encontrado'], 404);
            }

            // Remove the oficio
            $em->remove($oficio);
            $em->flush();
            
            return new JsonResponse([
                'success' => true,
                'message' => 'Oficio eliminado correctamente'
            ]);
            
        } catch (\Exception $e) {
            return new JsonResponse([
                'success' => false,
                'error' => 'No se pudo eliminar el oficio',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}

