<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Mail\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    public function contactEmail(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'firstname' => ['required', 'min:2'],
                'lastname' => ['required', 'min:2'],
                'email' => ['required', 'email'],
                'message' => ['required', 'min:2']
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }
        
            $data = $request->only(['firstname', 'lastname', 'email', 'message']);
        
            // Send the email
            Mail::to('info@ore-zone.com')->send(new Contact($data));
        
            // return response()->json(['success' => 'Email sent successfully!']);
            return successResponseHandler('Email sent successfully!', $data);

        } catch (\Exception $e) {
            return errorResponseHandler($e->getMessage());
        }
    }
}
