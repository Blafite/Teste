<?php

namespace App\Http\Controllers;

use App\Pdf\PdfGenerator;
use Illuminate\Http\Request;

class PdfController extends Controller
{
    public function generatePdf()
       {
           $pdf = new PdfGenerator();
           $pdf->generatePdf('EMPRESA', 'NOME', 'TEXTO 2', 'TEXTO 3', 'TEXTO 4');
           $pdf->Output('arquivo.pdf', 'F');
       }
}
