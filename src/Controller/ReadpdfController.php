<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Knp\Bundle\SnappyBundle\Snappy\Response\PdfResponse;

/**
 * Import the PDF Parser class
 */
use Smalot\PdfParser\Parser;

class ReadpdfController extends Controller
{
    /**
     * @Route("/readpdf", name="readpdf")
     */
    public function readPdfAction(Request $request)
    {
        // The relative or absolute path to the PDF file
        $pdfFile = $request->files->get('pdf-file');
        if (!is_object($pdfFile)) {
            return $this->uploadPdfAction('Select een pdf bestand' );
        }
        $pdfFilePath = $pdfFile->getPathName();
        $originFileName = $pdfFile->getClientOriginalName();
        // Create an instance of the PDFParser
        $PDFParser = new Parser();

        // Create an instance of the PDF with the parseFile method of the parser
        // this method expects as first argument the path to the PDF file
        $pdf = $PDFParser->parseFile($pdfFilePath);

        // Retrieve all pages from the pdf file.
        $pages  = $pdf->getPages();

        // Retrieve the number of pages by counting the array
        $totalPages = count($pages);

        // Set the current page as the first (a counter)
        $currentPage = 1;

        // Create an empty variable that will store thefinal text
        $text = "";

        // Loop over each page to extract the text
        foreach ($pages as $page) {

            // Add a HTML separator per page e.g Page 1/14
            $text .= "<h3>Page $currentPage/$totalPages</h3> </br>";

            // Concatenate the text
            $text .= $page->getText();

            // Increment the page counter
            $currentPage++;
        }

        return $this->render('readpdf/readpdf.html.twig', [
            'pdftext' => $text,
            'originFileName' => $originFileName
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