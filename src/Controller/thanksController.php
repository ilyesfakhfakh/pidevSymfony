<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Waste;
use App\Form\waste2Type;
use App\Repository\WasteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Notification;

use App\Repository\TruckRepository;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class thanksController extends AbstractController
{

    #[Route('/thanks', name: 'thanks')]
    public function thanks(Request $request): Response
    {
        // Get the waste_info query parameter from the request
        $wasteInfo = $request->query->get('waste_info');
    
        // Pass the waste_info parameter to the template
        return $this->render('waste/confirmation.html.twig', [
            'waste_info' => $wasteInfo,
        ]);
    }
    
    
}