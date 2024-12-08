<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class QRCodeController extends Controller
{
    // Display the form
    public function showForm()
    {
        return view('admin.qrcode');
    }

    // Handle form submission and display the QR code
    public function generateQRCode(Request $request)
    {
        // Validate form data
        $validated = $request->validate([
            'size' => 'required|integer|min:100|max:1000',
            'color' => 'required|integer|min:1|max:10',
            'transparent' => 'required|boolean',
            'amount' => 'required|numeric|min:0.01',
            'currencyCode' => 'required|string|max:3',
            'dueDate' => 'required|date_format:Ymd',
            'variableSymbol' => 'nullable|integer|max:9999999999',
            'constantSymbol' => 'nullable|integer|max:9999',
            'specificSymbol' => 'nullable|integer|max:9999999999',
            'paymentNote' => 'nullable|string|max:255',
            'iban' => 'required|string|max:34',
            'beneficiaryName' => 'required|string|max:255',
            'beneficiaryAddressLine1' => 'nullable|string|max:255',
            'beneficiaryAddressLine2' => 'nullable|string|max:255',
        ]);

        // Build the API URL with query parameters
        $apiUrl = 'https://api.freebysquare.sk/pay/v1/generate-png?' . http_build_query($validated);

        // Return the form with the generated QR code URL
        return view('admin.qrcode', ['qrCodeUrl' => $apiUrl]);
    }
}
