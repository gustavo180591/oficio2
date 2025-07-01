<?php

namespace App\Controller;

use App\Repository\OficioRepository;
use App\Repository\RecomendacionRepository;
use App\Repository\RegistroRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FullListController extends AbstractController
{
    #[Route('/list', name: 'app_full_list')]
    public function index(
        Request $request,
        OficioRepository $oficioRepository,
        RecomendacionRepository $recomendacionRepository,
        PaginatorInterface $paginator
    ): Response {
        $searchTerm = $request->query->get('q', '');
        $status = $request->query->get('status');
        
        // Construir la consulta con búsqueda y filtro
        $queryBuilder = $oficioRepository->createQueryBuilder('o');
        
        if ($searchTerm) {
            $queryBuilder->andWhere('o.name LIKE :searchTerm')
                ->setParameter('searchTerm', '%' . $searchTerm . '%');
        }
        
        if ($status !== null) {
            $queryBuilder->andWhere('o.status = :status')
                ->setParameter('status', $status === '1');
        }
        
        // Paginar los resultados
        $pagination = $paginator->paginate(
            $queryBuilder->getQuery(),
            $request->query->getInt('page', 1),
            10 // Número de elementos por página
        );
        
        return $this->render('full_list/index.html.twig', [
            'pagination' => $pagination,
            'searchTerm' => $searchTerm,
            'currentStatus' => $status,
            'recomendaciones' => $recomendacionRepository->findAll()
        ]);
    }
    #[Route('/register', name: 'app_full_register')]
    public function regist(
        Request $request,
        RegistroRepository $registroRepository,
        PaginatorInterface $paginator
    ): Response {
        $searchTerm = $request->query->get('q', '');
        $status = $request->query->get('status');
        
        // Construir la consulta con búsqueda y filtro
        $queryBuilder = $registroRepository->createQueryBuilder('r')
            ->leftJoin('r.oficio', 'o')
            ->addSelect('o');
        
        if ($searchTerm) {
            $queryBuilder->andWhere('r.name LIKE :searchTerm OR r.email LIKE :searchTerm OR r.phone LIKE :searchTerm OR o.name LIKE :searchTerm')
                ->setParameter('searchTerm', '%' . $searchTerm . '%');
        }
        
        if ($status !== null) {
            $queryBuilder->andWhere('r.status = :status')
                ->setParameter('status', $status === '1');
        }
        
        // Ordenar por fecha de creación descendente
        $queryBuilder->orderBy('r.createdAt', 'DESC');
        
        // Paginar los resultados
        $pagination = $paginator->paginate(
            $queryBuilder->getQuery(),
            $request->query->getInt('page', 1),
            10 // Número de elementos por página
        );
        
        return $this->render('full_list/registro.html.twig', [
            'pagination' => $pagination,
            'searchTerm' => $searchTerm,
            'currentStatus' => $status
        ]);
    }
}
