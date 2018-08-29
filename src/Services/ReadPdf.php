<?php

namespace App\Services;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;
use Smalot\PdfParser\Parser;
//use Symfony\Component\HttpFoundation\RedirectResponse;


class ReadPdf
{

    public function getPdfContent(Request $request)
    {

        // The relative or absolute path to the PDF file
        $pdfFile = $request->files->get('pdf-file');
        if (!is_object($pdfFile)) {
            return false;
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

        return array("originFileName"=>$originFileName, "pdfText"=>$text);
    }
}