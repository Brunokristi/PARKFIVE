<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR Code Generator</title>
    <!-- Include Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">QR Code Generator</h1>

        <!-- Display the form -->
        <form action="/generate-qrcode" method="POST" class="row g-3">
            @csrf

            <div class="col-md-6">
                <label for="size" class="form-label">QR Code Size (pixels)</label>
                <input type="number" name="size" id="size" class="form-control" value="400" required>
            </div>

            <div class="col-md-6">
                <label for="color" class="form-label">Color Scheme</label>
                <input type="number" name="color" id="color" class="form-control" value="3" required>
            </div>

            <div class="col-md-6">
                <label for="transparent" class="form-label">Transparent Background</label>
                <select name="transparent" id="transparent" class="form-select">
                    <option value="1">Yes</option>
                    <option value="0">No</option>
                </select>
            </div>

            <div class="col-md-6">
                <label for="amount" class="form-label">Payment Amount</label>
                <input type="text" name="amount" id="amount" class="form-control" value="10.00" required>
            </div>

            <div class="col-md-6">
                <label for="currencyCode" class="form-label">Currency Code</label>
                <input type="text" name="currencyCode" id="currencyCode" class="form-control" value="EUR" required>
            </div>

            <div class="col-md-6">
                <label for="dueDate" class="form-label">Due Date (YYYYMMDD)</label>
                <input type="text" name="dueDate" id="dueDate" class="form-control" value="20220524" required>
            </div>

            <div class="col-md-6">
                <label for="variableSymbol" class="form-label">Variable Symbol</label>
                <input type="text" name="variableSymbol" id="variableSymbol" class="form-control" value="1234567890">
            </div>

            <div class="col-md-6">
                <label for="constantSymbol" class="form-label">Constant Symbol</label>
                <input type="text" name="constantSymbol" id="constantSymbol" class="form-control" value="1234">
            </div>

            <div class="col-md-6">
                <label for="specificSymbol" class="form-label">Specific Symbol</label>
                <input type="text" name="specificSymbol" id="specificSymbol" class="form-control" value="1234567890">
            </div>

            <div class="col-md-6">
                <label for="paymentNote" class="form-label">Payment Note</label>
                <textarea name="paymentNote" id="paymentNote" class="form-control">Testovacia platba</textarea>
            </div>

            <div class="col-md-6">
                <label for="iban" class="form-label">IBAN</label>
                <input type="text" name="iban" id="iban" class="form-control" value="SK8975000000000012345671" required>
            </div>

            <div class="col-md-6">
                <label for="beneficiaryName" class="form-label">Beneficiary Name</label>
                <input type="text" name="beneficiaryName" id="beneficiaryName" class="form-control" value="Neplat Ma" required>
            </div>

            <div class="col-md-6">
                <label for="beneficiaryAddressLine1" class="form-label">Beneficiary Address Line 1</label>
                <input type="text" name="beneficiaryAddressLine1" id="beneficiaryAddressLine1" class="form-control" value="Teraforma 15">
            </div>

            <div class="col-md-6">
                <label for="beneficiaryAddressLine2" class="form-label">Beneficiary Address Line 2</label>
                <input type="text" name="beneficiaryAddressLine2" id="beneficiaryAddressLine2" class="form-control" value="Kalinovo, 987 05">
            </div>

            <div class="col-12 text-center">
                <button type="submit" class="btn btn-primary">Generate QR Code</button>
            </div>
        </form>

        <!-- Display the QR code if available -->
        @if(isset($qrCodeUrl))
            <div class="mt-5 text-center">
                <h2>Generated QR Code:</h2>
                <img src="{{ $qrCodeUrl }}" alt="Generated QR Code" class="img-fluid">
            </div>
        @endif
    </div>

    <!-- Include Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
