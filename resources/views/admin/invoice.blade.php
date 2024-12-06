<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR Code Generator</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        #qrCodeContainer img {
            margin-top: 20px;
            border: 1px solid #ccc;
            padding: 10px;
        }
    </style>
</head>
<body>
    <div class="container my-5">
        <h1 class="h4 text-center">QR Code Generator</h1>
        <form id="qrForm" class="mt-4">
            <div class="mb-3">
                <label for="price" class="form-label">Price</label>
                <input type="number" step="0.01" id="price" name="price" class="form-control" placeholder="Enter price" required>
            </div>

            <div class="mb-3">
                <label for="note" class="form-label">Note</label>
                <input type="text" id="note" name="note" class="form-control" placeholder="Enter a note">
            </div>

            <div class="mb-3">
                <label for="iban" class="form-label">IBAN</label>
                <input type="text" id="iban" name="iban" class="form-control" placeholder="Enter IBAN" required>
            </div>

            <div class="mb-3">
                <label for="swift" class="form-label">SWIFT</label>
                <input type="text" id="swift" name="swift" class="form-control" placeholder="Enter SWIFT code" required>
            </div>

            <div class="mb-3">
                <label for="vs" class="form-label">Variable Symbol (VS)</label>
                <input type="text" id="vs" name="vs" class="form-control" placeholder="Enter Variable Symbol">
            </div>

            <div class="mb-3">
                <label for="ss" class="form-label">Specific Symbol (SS)</label>
                <input type="text" id="ss" name="ss" class="form-control" placeholder="Enter Specific Symbol">
            </div>

            <div class="mb-3">
                <label for="cs" class="form-label">Constant Symbol (CS)</label>
                <input type="text" id="cs" name="cs" class="form-control" placeholder="Enter Constant Symbol">
            </div>

            <div class="mb-3">
                <label for="recipient" class="form-label">Recipient</label>
                <input type="text" id="recipient" name="recipient" class="form-control" placeholder="Enter recipient name" required>
            </div>

            <div class="mb-3">
                <label for="pixelsize" class="form-label">Pixel Size</label>
                <input type="number" id="pixelsize" name="pixelsize" class="form-control" value="1" required>
            </div>

            <div class="mb-3">
                <label for="pixelpadding" class="form-label">Pixel Padding</label>
                <input type="number" id="pixelpadding" name="pixelpadding" class="form-control" value="0" required>
            </div>

            <button type="button" id="generateQrButton" class="btn btn-primary w-100">Generate QR Code</button>
        </form>

        <div id="qrCodeContainer" class="text-center mt-5">
            <p class="text-muted">Your QR code will appear here</p>
        </div>
    </div>

    <script>
        document.getElementById('generateQrButton').addEventListener('click', function () {
            const form = document.getElementById('qrForm');
            const formData = new FormData(form);

            // Construct URL
            const baseUrl = 'https://stayparkfive.com/qr-generator/qr.php';
            const queryParams = new URLSearchParams();

            formData.forEach((value, key) => {
                queryParams.append(key, value);
            });

            const qrUrl = `${baseUrl}?${queryParams.toString()}`;
            console.log(qrUrl);

            // Display QR code
            const qrCodeContainer = document.getElementById('qrCodeContainer');
            qrCodeContainer.innerHTML = `
                <img src="${qrUrl}" alt="Generated QR Code">
            `;
        });
    </script>
</body>
</html>
