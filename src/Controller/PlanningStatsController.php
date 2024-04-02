<?php

namespace App\Controller;

use App\Repository\PlanificationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PlanningStatsController extends AbstractController
{
    #[Route('/planning/stats', name: 'app_planning_stats')]
    public function index(PlanificationRepository $PlanificationRepository): Response
    {
        $PlanificationStatistics = $PlanificationRepository->getplanStatistics();

        $labels = [];
        $data = [];

        foreach ($PlanificationStatistics as $statistic) {
            $labels[] = $statistic['location'];
            $data[] = $statistic['count'];
        }
        return $this->render('planning_stats/index.html.twig', [
            'labels' => json_encode($labels),
            'data' => json_encode($data),
        ]);
    }
}
