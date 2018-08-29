<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Knp\Bundle\SnappyBundle\Snappy\Response\PdfResponse;
use App\Services\ReadPdf;
use Psr\Log\LoggerInterface;

/**
 * Import the PDF Parser class
 */
//use Smalot\PdfParser\Parser;

class ReadpdfController extends Controller
{

    // ReadPdf with service
    /**
     * @Route("/readpdf", name="readpdf")
     */
    public function readPdfAction(Request $request, ReadPdf $pdfObj, LoggerInterface $logger)
    {
        $returnArray = $pdfObj->getPdfContent($request);
        if(!$returnArray) {
            return $this->uploadPdfAction('Select een pdf bestand' );
        }
        return $this->render('readpdf/readpdf.html.twig', [
            'pdftext' => $returnArray['pdfText'],
            'originFileName' => $returnArray['originFileName']
        ]);

        // Send the text as response in the controller
        return new Response($text);
    }

    /**
    * @Route("/savepdf", name="savepdf")
    */
    public function savePdfAction(Request $request)
    {
        if ($request->getMethod() == 'POST') {
            $html = $request->get('pdftextarea');
            $fileName = $request->get('new-pdf-filename');

            return new PdfResponse(
                $this->get('knp_snappy.pdf')->getOutputFromHtml($html),
                $fileName
            );

            return $this->render('readpdf/upload.html.twig', array(
                'pdftext' => 'Upload pdf file',
                'message' => 'Pdf saved successfully',
            ));
        }

    }

    /**
    * @Route("/", name="uploadpdf")
    */
    public function uploadPdfAction($msg = 'Start importeren')
    {
        return $this->render('readpdf/upload.html.twig', array(
            'pdftext' => 'Upload pdf file',
            'message' => $msg,
        ));

    }

}
