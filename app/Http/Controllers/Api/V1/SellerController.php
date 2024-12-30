<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Seller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class SellerController extends Controller
{
    public function getSellers()
    {
        try {
            $sellers = Seller::with(['user'])->latest()->get();

            return successResponseHandler('Sellers fetched successfully', $sellers);

        } catch (\Exception $e) {
            return errorResponseHandler($e->getMessage());
        }
    }

    public function find($id)
    {
        try {
            $seller = Seller::with('user')->find($id);

            if (!$seller) {
                return notFoundResponseHandler('Seller not found.');
            }

            return successResponseHandler('seller found', $seller);
            
        } catch (\Exception $e) {
            return errorResponseHandler($e->getMessage());
        }
    }

    public function registerSeller(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users,email',
                'password' => 'required|string|min:8|max:255|confirmed',
                'role' => 'required|string|in:admin,buyer,seller',
                'id_number' => ['required', 'min:11', 'max:12', 'unique:sellers,id_number'],
                'country' => ['required'],
                'business_name' => ['required'],
                'phone' => ['required', 'min:9', 'max:14']
            ]);

            if ($validator->fails()) {
                return errorValidationResponseHandler($validator->errors());
            }

            DB::beginTransaction();

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => $request->role
            ]);

            $seller = Seller::create([
                'user_id' => $user->id,
                'id_number' => $request->id_number,
                'country' => $request->country,
                'business_name' => $request->business_name,
                'phone' => $request->phone
            ]);

            DB::commit();

            // Load the associated user for the seller
            $seller->load('user');

            return successResponseHandler('seller created successfully', $seller);

        } catch (\Exception $e) {
            DB::rollBack();
            return errorResponseHandler($e->getMessage());
        }

    }

    public function update(Request $request, $id)
    {
        try {
            $seller = Seller::find($id);

            if (!$seller) {
                return notFoundResponseHandler('Seller not found.');
            }

            $request->validate([
                'id_number' => 'string|max:11',
                'country' => 'string|max:255',
                'business_name' => 'string|max:255',
                'phone' => 'string|max:14'
            ]);

            $seller->update($request->all());

            return successResponseHandler('Seller updated successfully.', $seller);

        } catch (\Exception $e) {
            return errorResponseHandler($e->getMessage());
        }

    }
}
