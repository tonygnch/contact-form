<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use App\Http\Resources\InquiryResource;
use App\Models\Inquiry;
use App\Notifications\InquiryEmailNotification;
use App\Notifications\UserEmailNotification;
use Illuminate\Http\JsonResponse;
use Illuminate\Database\Eloquent\InvalidCastException;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use InvalidArgumentException;

class ContactController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Show the contact page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('contact');
    }

    /**
     * Store inquiry
     * 
     * @param ContactRequest $request 
     * @return JsonResponse 
     */
    public function store(ContactRequest $request)
    {
        # Create new model
        $inquiry = new Inquiry();

        # Fill in the properties
        $inquiry->name = $request->name;
        $inquiry->email = $request->email;
        $inquiry->phone = $request->phone;
        $inquiry->message = $request->message;

        # Save the model
        $inquiry->save();

        # Send notification to logged user
        Auth::user()->notify(new UserEmailNotification($inquiry));

        # Send notiication to inquiry user
        $inquiry->notify(new InquiryEmailNotification());

        # Return json response
        return response()->json([
            'status' => 'ok',
            'data' => new InquiryResource($inquiry)
        ]);
    }
}
