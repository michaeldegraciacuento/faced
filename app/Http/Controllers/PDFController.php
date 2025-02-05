<?php

namespace App\Http\Controllers;

use App\Models\Household;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf; // Ensure DOMPDF is installed

class PDFController extends Controller
{
    public function generatePDF($id)
    {
        $household = Household::findOrFail($id);

        // Data to pass to the view
        $data = [
            'household' => $household,
        ];

        $pdf = Pdf::loadView('pdf.household_form', $data); // View for the PDF

        return $pdf->stream('household_form_' . $household->id . '.pdf'); // Display in browser
    }
}
