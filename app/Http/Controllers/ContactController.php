<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Services\UserAgentServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    private $userAgentService;

    public function __construct(UserAgentServiceInterface $userAgentService)
    {
        $this->userAgentService = $userAgentService;
    }
    //

    public function index(){
        return response()->json(Contact::all(), 200);
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $userAgent = $request->header('User-Agent');
        $ipAddress = $request->ip();
        $deviceType = $this->userAgentService->detectDevice($userAgent);
        $browser = $this->userAgentService->detectBrowser($userAgent);
        $os = $this->userAgentService->detectOS($userAgent);
        $location = $this->userAgentService->getLocationFromIP($ipAddress);

        $contact = new Contact();
        $contact->name = $request->input('name');
        $contact->email = $request->input('email');
        $contact->subject = $request->input('subject');
        $contact->message = $request->input('message');
        $contact->ip_address = $ipAddress;
        $contact->user_agent = $userAgent;
        $contact->device_type = $deviceType;
        $contact->browser = $browser;
        $contact->os = $os;
        $contact->location = $location;
        $contact->save();

        return response()->json($contact, 201);
    }

}
