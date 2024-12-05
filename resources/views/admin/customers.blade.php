<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Zákazníci</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @vite('resources/js/customer.js')
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
        <!-- Header Section -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h4">Zákazníci</h1>
        </div>

    
        <!-- Table Section -->
        <table class="table table-hover">
        <thead class="table-light">
            <tr>
                <th scope="col">Meno</th>
                <th scope="col">Email</th>
                <th scope="col"></th>
                <th scope="col">Telefón</th>
                <th scope="col"></th>
                <th scope="col" class="text-end"></th>
            </tr>
        </thead>
        <tbody>
            @if ($users->isEmpty())
                <tr>
                    <td colspan="4" class="text-center">Žiadni zákazníci neboli nájdení.</td>
                </tr>
            @else
                @foreach ($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        <a href="mailto:{{ $user->email }}"><button type="button" class="btn btn-sm btn-light ms-3"> Poslať email</button></a>
                    </td>
                    <td>{{ $user->phone }}</td>
                    <td>
                        @if ($user->phone)
                            <a href="tel:{{ $user->phone }}"><button type="button" class="btn btn-sm btn-light ms-3"> Zavolať</button></a>
                        @endif
                    </td>
                    <td class="text-end">
                        <button type="button" 
                            class="btn btn-sm btn-secondary edit-user-button" 
                            data-bs-toggle="modal" 
                            data-bs-target="#editCustomer" 
                            data-user-id="{{ $user->id }}">
                        Viac informáci
                    </button>
                    </td>
                </tr>
                @endforeach
            @endif
        </tbody>
    </table>


    <div class="modal fade" id="editCustomer" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="editCustomerLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="editRoomLabel">Zákazník</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                    <form id="editCustomerForm" action="{{ route('users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- ID -->
                        <small>ID zákazníka: <span id="editCustomerId"></span></small>



                        <div class="text-divider mb-2">
                            <hr>
                            <span>Základné údaje</span>
                            <hr>
                        </div>



                        <!-- Name -->
                        <div class="mb-3">
                            <label for="editName" class="form-label">Meno</label>
                            <input type="text" class="form-control" id="editName" name="name" maxlength="100" required>
                        </div>

                        <!-- Email -->
                        <div class="mb-3">
                            <label for="editEmail" class="form-label">Email</label>
                            <input type="email" class="form-control" id="editEmail" name="email" maxlength="255" required>
                        </div>

                        <!-- Phone -->
                        <div class="mb-3">
                            <label for="editPhone" class="form-label">Telefón</label>
                            <input type="text" class="form-control" id="editPhone" name="phone" maxlength="15">
                        </div>


                        <div class="text-divider mb-2">
                            <hr>
                            <span>Fakturačné údaje</span>
                            <hr>
                        </div>


                        <!-- Address -->
                        <div class="row mb-3">
                            <div class="col">
                                <label for="editStreet" class="form-label">Ulica</label>
                                <input type="text" class="form-control" id="editStreet" name="street" maxlength="255">
                            </div>
                            <div class="col">
                                <label for="editCity" class="form-label">Mesto</label>
                                <input type="text" class="form-control" id="editCity" name="city" maxlength="100">
                            </div>
                        </div>

                        <!-- ZIP Code -->
                        <div class="mb-3">
                            <label for="editZipCode" class="form-label">PSČ</label>
                            <input type="text" class="form-control" id="editZipCode" name="zip_code" maxlength="10">
                        </div>

                        

                        <div class="text-divider mb-2">
                            <hr>
                            <span>Firemné údaje</span>
                            <hr>
                        </div>
                        
                        
                        <!-- Is Company -->
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="editCompany" name="is_company">
                            <label class="form-check-label" for="editCompany">Fakturovať na firmu</label>
                        </div>

                        <!-- Company Name -->
                        <div class="mb-3">
                            <label for="editCompanyName" class="form-label">Názov Firmy</label>
                            <input type="text" class="form-control" id="editCompanyName" name="company_name" maxlength="100">
                        </div>

                        <!-- Tax Information -->
                        <div class="row mb-3">
                            <div class="col">
                                <label for="editICO" class="form-label">IČO</label>
                                <input type="text" class="form-control" id="editICO" name="ICO" maxlength="20">
                            </div>
                            <div class="col">
                                <label for="editDIC" class="form-label">DIČ</label>
                                <input type="text" class="form-control" id="editDIC" name="DIC" maxlength="20">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="editICDPH" class="form-label">IČ DPH</label>
                            <input type="text" class="form-control" id="editICDPH" name="ICDPH" maxlength="20">
                        </div>




                        <div class="text-divider mb-2">
                            <hr>
                            <span>Platobné údaje</span>
                            <hr>
                        </div>




                        <!-- Bank Information -->
                        <div class="row mb-3">
                            <div class="col">
                                <label for="editIBAN" class="form-label">IBAN</label>
                                <input type="text" class="form-control" id="editIBAN" name="IBAN" maxlength="100">
                            </div>
                            <div class="col">
                                <label for="editBIC" class="form-label">BIC (SWIFT)</label>
                                <input type="text" class="form-control" id="editBIC" name="BIC" maxlength="10">
                            </div>
                        </div>

                        <!-- Account Owner -->
                        <div class="mb-3">
                            <label for="editAccountOwner" class="form-label">Vlastník Účtu</label>
                            <input type="text" class="form-control" id="editAccountOwner" name="account_owner" maxlength="100">
                        </div>

                        <!-- Submit Button -->
                        <div class="mt-3">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Zavrieť</button>
                            <button type="submit" class="btn btn-primary">Uložiť</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
    </div>