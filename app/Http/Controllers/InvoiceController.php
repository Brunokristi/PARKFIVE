<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Dompdf\Dompdf;

class InvoiceController extends Controller
{
    public function showForm()
    {
        return view('admin.payments');
    }

    public function generateInvoice(Request $request)
    {
        // Validate the invoice form
        $validated = $request->validate([
            'supplier_name' => 'required|string|max:255',
            'supplier_address' => 'required|string|max:255',
            'supplier_ico' => 'required|string|max:20',
            'supplier_dic' => 'required|string|max:20',
            'customer_name' => 'required|string|max:255',
            'customer_address' => 'required|string|max:255',
            'customer_ico' => 'required|string|max:20',
            'customer_dic' => 'required|string|max:20',
            'customer_icdph' => 'nullable|string|max:20',
            'iban' => 'required|string|max:34',
            'payment_method' => 'required|string|max:50',
            'variable_symbol' => 'nullable|integer|max:9999999999',
            'issue_date' => 'required|date',
            'due_date' => 'required|date',
            'items' => 'required|array',
            'items.*.description' => 'required|string|max:255',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
        ]);

        // Calculate totals
        $total = 0;
        foreach ($validated['items'] as $item) {
            $item['total'] = $item['quantity'] * $item['unit_price'];
            $total += $item['total'];
        }

        // Generate the QR code URL
        $qrCodeUrl = 'https://api.freebysquare.sk/pay/v1/generate-png?' . http_build_query([
            'amount' => $total,
            'currencyCode' => 'EUR',
            'variableSymbol' => $validated['variable_symbol'],
            'iban' => $validated['iban'],
            'beneficiaryName' => $validated['supplier_name'],
            'beneficiaryAddressLine1' => $validated['supplier_address'],
            'paymentNote' => 'Invoice Payment',
        ]);

        // Pass data to the view
        $data = array_merge($validated, [
            'total' => $total,
            'qr_code' => $qrCodeUrl,
        ]);

        // Generate the PDF
        $html = view('admin.invoice_template', $data)->render();

        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        // Stream or download the PDF
        return $dompdf->stream('invoice.pdf');
    }
}
