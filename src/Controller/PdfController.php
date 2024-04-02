<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Dompdf\Dompdf;
use Dompdf\Options;
use App\Entity\Waste;
use App\Entity\Notification;


class PdfController extends AbstractController
{
    #[Route('/generate-pdf', name: 'generate_pdf')]
    public function generatePdf(): Response
    {
        // Get the EntityManager
        $entityManager = $this->getDoctrine()->getManager();

        // Fetch data from the Waste table
        $wasteRepository = $entityManager->getRepository(Waste::class);
        $wastes = $wasteRepository->findAll();

        // Create a new Dompdf instance
        $dompdf = new Dompdf();

        // Load HTML content from a Twig template
        $html = $this->renderView('waste/content.html.twig', [
            'wastes' => $wastes,
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