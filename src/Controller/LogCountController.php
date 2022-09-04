<?php

namespace App\Controller;

use App\Filter\ElasticSearch\ElasticSearchFilter;
use FOS\ElasticaBundle\Finder\PaginatedFinderInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LogCountController
{
    public function __construct(
        private readonly PaginatedFinderInterface $finder,
        private readonly ElasticSearchFilter $elasticSearchFilter,
    ){}

    #[Route(path: '/log/count', methods: ['GET'])]
    public function __invoke(Request $request): Response
    {
        $queryParams = $request->query->all();
        $query = $this->elasticSearchFilter->createQuery($queryParams);
        $paginated = $this->finder->findPaginated($query);

        return new JsonResponse(['count' => $paginated->getNbResults()]);
    }
}