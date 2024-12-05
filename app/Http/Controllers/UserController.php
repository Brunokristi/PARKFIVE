<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function index()
    {
        $users = User::where('role', '!=', 'admin')->get();
        return view('admin.customers', ['users' => $users]);
    }

    public function edit($id)
    {
        Log::info('User ID: ' . $id);
        $user = User::find($id);
        $response = [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $user->phone,
            'billing_name' => $user->billing_name,
            'street' => $user->street,
            'city' => $user->city,
            'zip' => $user->zip_code,
            'is_company' => $user->is_company,
            'company_name' => $user->company_name,
            'ico' => $user->ICO,
            'dic' => $user->DIC,
            'ic_dph' => $user->ICDPH,
            'bic' => $user->BIC_SWIFT,
            'iban' => $user->IBAN,
            'account_owner' => $user->account_owner
        ];

        return response()->json($response);
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->billing_name = $request->billing_name;
        $user->street = $request->street;
        $user->city = $request->city;
        $user->zip_code = $request->zip_code;
        $user->is_company = $request->has('is_company');
        $user->company_name = $request->company_name;
        $user->ICO = $request->ICO;
        $user->DIC = $request->DIC;
        $user->ICDPH = $request->ICDPH;
        $user->BIC_SWIFT = $request->BIC;
        $user->IBAN = $request->IBAN;
        $user->account_owner = $request->account_owner;
        $user->save();

        return redirect()->back()->with('success', 'Room updated successfully!');
    }
}
