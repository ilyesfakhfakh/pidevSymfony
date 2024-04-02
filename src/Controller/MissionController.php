<?php

namespace App\Controller;

use App\Entity\Mission;
use App\Form\MissionType;
use App\Repository\MissionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Dompdf\Dompdf;
use Dompdf\Options;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


#[Route('/mission')]
class MissionController extends AbstractController
{
    #[Route('/', name: 'app_mission_index', methods: ['GET'])]
    public function index(MissionRepository $missionRepository,Request $request): Response
    {
        // Pagination
    $page = $request->query->getInt('page', 1);
    $pageSize = 4; // Number of items per page
    $totalMissionsCount = count($missionRepository->findAll());
    $totalPages = ceil($totalMissionsCount / $pageSize);

    // Fetch the stocks for the current page
    $offset = ($page - 1) * $pageSize;

    // Handle search query
    $searchQuery = $request->query->get('search');
    $sortField = $request->query->get('sortField', 'start_date');
    $sortOrder = $request->query->get('sortOrder', 'asc');

        //add statistics
        $MissionStatistics = $missionRepository->getMissionStatistics();

        $labels = [];
        $data = [];

        foreach ($MissionStatistics as $statistic) {
            $labels[] = $statistic['type_d'];
            $data[] = $statistic['count'];
        }

    if ($searchQuery) {
        $missions = $missionRepository->findBySearch($searchQuery);
        $totalmissionsCount = count($missions);
        $totalPages = ceil($totalmissionsCount / $pageSize);
    } else {
        $missions = $missionRepository->findAllWithSorting($sortField, $sortOrder, $pageSize, $offset);
    }

    $sortOptions = [
        'start_date' => 'start date',
        'location' => 'location',
    ];


        return $this->render('mission/index.html.twig', [
            'missions' => $missions,
             'page' => $page,
            'total_pages' => $totalPages,
            'sortOptions' => $sortOptions,
            'currentSortField' => $sortField,
            'currentSortOrder' => $sortOrder,
            'labels' => json_encode($labels),
            'data' => json_encode($data),
            
        ]);
    }

    #[Route('/pdf-dom', name: 'pdf_dom',methods: ['GET'])]
        public function generatePdfWithDompdf(MissionRepository $repoP)
        {
    // Create a new instance of Dompdf
    $options = new Options();
    $options->set('defaultFont', 'Arial');
    $dompdf = new Dompdf($options);

    // Generate the HTML content
    $html = $this->renderView('mission/pdf.html.twig', [
        'missions' => $repoP->findAll(),
    ]);

    // Load the HTML content into the DOM
    $dompdf->loadHtml($html);

    $dompdf->setPaper('A4', 'portrait');
    // Render the PDF
    $dompdf->render();

    // Output the generated PDF to Browser (inline view)
    $dompdf->stream("Liste_Des_missions.pdf", [
        "missions" => true
    ]);
    }

    #[Route('/new', name: 'app_mission_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $mission = new Mission();
        $mission ->setStartDate(new \DateTimeImmutable());
        $mission ->setEndDate(new \DateTimeImmutable());
        $form = $this->createForm(MissionType::class, $mission);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $mission->setTypeD($mission->getIdWaste()->getType());
            $mission->setLocation($mission->getIdWaste()->getLocation());
            $mission->setStatus('Undone');

            $existingMission = $entityManager->getRepository(Mission::class)->findOneBy(['id_waste' => $mission->getIdWaste()]);

            if ($existingMission) {
                $this->addFlash('error', 'A mission with this waste ID already exists.');
            } else {
                $entityManager->persist($mission);
                $entityManager->flush();
    
                $this->addFlash('success', 'Mission created successfully.');
            }

            

            return $this->redirectToRoute('app_mission_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('mission/new.html.twig', [
            'mission' => $mission,
            'form' => $form,
        ]);
    }

    

    #[Route('/{id_mission}/edit', name: 'app_mission_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Mission $mission, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(MissionType::class, $mission);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_mission_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('mission/edit.html.twig', [
            'mission' => $mission,
            'form' => $form,
        ]);
    }

    
    #[Route('/{id_mission}', name: 'app_mission_delete')]
    public function delete( MissionRepository $repo,$id_mission, ManagerRegistry $mr): Response
    {
        $mission=$repo->find($id_mission);
        $em=$mr->getManager();
        $em->remove($mission);
        $em->flush();

        return $this->redirectToRoute('app_mission_index', [], Response::HTTP_SEE_OTHER);
    }
}
