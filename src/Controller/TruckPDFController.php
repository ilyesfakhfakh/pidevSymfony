<?php

namespace App\Controller;

use App\Entity\Truck;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Dompdf\Dompdf;
use App\Entity\Notification;

use Dompdf\Options;

class TruckPDFController extends AbstractController
{
    #[Route('/generate-pdf-Truck', name: 'generate_pdf_Truck')]
    public function TruckgeneratePdf(): Response
    {
        // Get the EntityManager
        $entityManager = $this->getDoctrine()->getManager();

        // Fetch data from the Waste table
        $truckRepository = $entityManager->getRepository(Truck::class);
        $trucks = $truckRepository->findAll();

        // Create a new Dompdf instance
        $dompdf = new Dompdf();

        // Load HTML content from a Twig template
        $html = $this->renderView('truck/content.html.twig', [
            'trucks' => $trucks,
        ]);

        // Load HTML content into Dompdf
        $dompdf->loadHtml($html);

        // (Optional) Set paper size and orientation
        $dompdf->setPaper('A4', 'portrait');

        // Render the PDF
        $dompdf->render();

        // Generate the PDF response
        $response = new Response($dompdf->output());
        $response->headers->set('Content-Type', 'application/pdf');

        return $response;
    }
}