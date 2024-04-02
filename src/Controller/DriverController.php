<?php

namespace App\Controller;

use App\Repository\MissionRepository;
use App\Repository\PlanificationRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
#[Route('/driver')]
class DriverController extends AbstractController
{
    #[Route('/', name: 'app_driver')]
    public function index(MissionRepository $repoM,PlanificationRepository $repP): Response
    {
        // Récupérer l'id du driver connecté
    $driver_id =1; /*$user->getId();*/

    // Récupérer les missions en fonction de l'id du driver
    $obj = $repoM->getMissionsByDriver($driver_id);

    // Récupérer la planification en fonction de l'id
    $result = $repP->find($driver_id);
    
    return $this->render(
        'driver/index.html.twig',
        ['missions' => $obj, 'j' => $result]
    );
    }
    
    #[Route('/DetailMissions/{id}',name:'Detail')]
function DetailMission($id,MissionRepository $repoM,PlanificationRepository $repP/*, UserInterface $user*/){
    // Récupérer l'id du driver connecté
    $driver_id =1; /*$user->getId();*/

    // Récupérer les missions en fonction de l'id du driver
    $obj = $repoM->getMissionsByDriver($driver_id);

    // Récupérer la planification en fonction de l'id
    $result = $repP->find($id);

    // Retourner la vue avec les missions et la planification
    return $this->render(
        'driver/index.html.twig',
        ['missions' => $obj, 'j' => $result]
    );
}


#[Route('/ValidateMission/{id}',name:'app_driver_validate')]
public function validateMission($id,Request $request,MissionRepository $repoM,ManagerRegistry $mr): Response
{
    $mission = $repoM->find($id);
    $mission->setStatus('completed');
    
    $entityManager = $mr->getManager();
    $entityManager->persist($mission);
    $entityManager->flush();

    return $this->redirectToRoute('app_driver', [], Response::HTTP_SEE_OTHER);

    
}

  #[Route("/start-mission/{id}", name:"start_mission")]
public function startMission($id,MissionRepository $repoM,ManagerRegistry $mr): Response
{
    $mission = $repoM->find($id);

    

    $mission->setStatus('ongoing');
    
    $entityManager = $mr->getManager();
    $entityManager->persist($mission);
    $entityManager->flush();

    return $this->redirectToRoute('app_driver', [], Response::HTTP_SEE_OTHER);
    /*return $this->render(
        'driver/missionStarted.html.twig',['mission'=>$mission]);*/
    
}
}
