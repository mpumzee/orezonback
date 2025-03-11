<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Seller;
use App\Models\SupplierMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class SupplierMessageController extends Controller
{
    public function index()
    {
        try {
            $messages = SupplierMessage::latest()->get();
            return successResponseHandler('fetched messages successfully', $messages);

        } catch (\Exception $e) {
            return errorResponseHandler($e->getMessage());
        }
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'productId' => ['required', 'exists:products,id'],
                'ProductName' => ['required'],
                'email' => ['required', 'email'],
                'message' => ['required'],
                'sellerId' => ['required']
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            $product = Product::find($request->productId);

            $seller = Seller::where('user_id', $product->user_id)->first();

            $message = SupplierMessage::create([
                'product_id' => $request->productId,
                'Product_name' => $request->ProductName,
                'email' => $request->email,
                'message' => $request->message,
                'seller_id' => $seller->id
            ]);

            return successResponseHandler('message sent', $message);
        } catch (\Exception $e) {
            return errorResponseHandler($e->getMessage());
        }
    }

    public function supplierMessages()
    {
        try {
            $seller = Seller::where('user_id', Auth::user()->id)->first();
            $msgs = SupplierMessage::where('seller_id', $seller->id)->latest()->get();

            return successResponseHandler('fetched messages successfully', $msgs);
        } catch (\Exception $e) {
            return errorResponseHandler($e->getMessage());
        }
    }

    public function getSupplierMessages($supplier_id)
    {
        try {
            $seller = Seller::find($supplier_id);
            if(!$seller) {
                return notFoundResponseHandler("Supplier not found");
            }
            $msgs = SupplierMessage::where('seller_id', $supplier_id)->latest()->get();

            return successResponseHandler('fetched messages successfully', $msgs);
        } catch (\Exception $e) {
            return errorResponseHandler($e->getMessage());
        }
    }
}
