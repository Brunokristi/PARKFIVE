<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Faktúry a Platby</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @vite('resources/js/payments.js')
    <style>
        .text-divider {
            display: flex;
            align-items: center;
            text-align: center;
        }

        .text-divider hr {
            flex-grow: 1;
            border: 0;
            border-top: 1px solid #ccc;
            margin: 0 10px; /* Spacing around the text */
        }

        .text-divider span {
            font-size: 14px; /* Adjust size */
            color: #666; /* Adjust text color */
        }
    </style>

</head>

<body class="bg-light">
    <div class="container my-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h4">Faktúry a Platby</h1>
        </div>
        <div class="d-flex justify-content-between align-items-center mb-4">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#newInvoice" id="createNewButton">
                Vytvoriť faktúru
            </button>
        </div>
    </div>

    <div class="modal fade" id="newInvoice" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="newInvoiceLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="newInvoiceLabel">Vytvoriť faktúru</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('generate.invoice') }}" method="POST" id="invoiceForm">
                        @csrf



                        <div class="text-divider mb-2">
                            <hr>
                            <span>Údaje o odoberateľovi</span>
                            <hr>
                        </div>



                        <!-- Customer Details -->
                        <div class="mb-3">
                            <label for="customerName" class="form-label">Meno Odberateľa</label>
                            <input type="text" class="form-control" id="customerName" name="customer_name" maxlength="255" required>
                        </div>

                        <div class="mb-3">
                            <label for="customerAddress" class="form-label">Adresa Odberateľa</label>
                            <input type="text" class="form-control" id="customerAddress" name="customer_address" maxlength="255" required>
                        </div>

                        <div class="row mb-3">
                            <div class="col">
                                <label for="customerICO" class="form-label">IČO</label>
                                <input type="text" class="form-control" id="customerICO" name="customer_ico" maxlength="20">
                            </div>
                            <div class="col">
                                <label for="customerDIC" class="form-label">DIČ</label>
                                <input type="text" class="form-control" id="customerDIC" name="customer_dic" maxlength="20">
                            </div>
                        </div>



                        <div class="text-divider mb-2">
                            <hr>
                            <span>Položky faktúry</span>
                            <hr>
                        </div>



                        <!-- Items -->
                        <div id="itemsContainer">
                            <div class="mb-3">
                                <label for="itemDescription0" class="form-label">Popis Položky</label>
                                <input type="text" class="form-control" id="itemDescription0" name="items[0][description]" maxlength="255" required>
                            </div>

                            <div class="row mb-3">
                                <div class="col">
                                    <label for="itemQuantity0" class="form-label">Počet</label>
                                    <input type="number" class="form-control" id="itemQuantity0" name="items[0][quantity]" min="1" required>
                                </div>
                                <div class="col">
                                    <label for="itemUnitPrice0" class="form-label">Cena za Jednotku</label>
                                    <input type="number" class="form-control" id="itemUnitPrice0" name="items[0][unit_price]" min="0" step="0.01" required>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-secondary mb-3" id="addItemButton">Pridať Položku</button>



                        <div class="text-divider mb-2">
                            <hr>
                            <span>Ostatné údaje</span>
                            <hr>
                        </div>



                        <!-- Dates -->
                        <div class="row mb-3">
                            <div class="col">
                                <label for="issueDate" class="form-label">Dátum Vystavenia</label>
                                <input type="date" class="form-control" id="issueDate" name="issue_date" required>
                            </div>
                            <div class="col">
                                <label for="dueDate" class="form-label">Dátum Splatnosti</label>
                                <input type="date" class="form-control" id="dueDate" name="due_date" required>
                            </div>
                        </div>


                        <div class="mt-3">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Zavrieť</button>
                            <button type="submit" class="btn btn-primary">Vytvoriť Faktúru</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</body>

</html>
