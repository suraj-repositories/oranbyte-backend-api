<?php

namespace App\Http\Controllers;

use App\Models\Subscriber;
use App\Services\UserAgentServiceInterface;
use Illuminate\Http\Request;

class SubscriberController extends Controller
{
    private $userAgentService;

    public function __construct(UserAgentServiceInterface $userAgentService)
    {
        $this->userAgentService = $userAgentService;
    }

    public function index(){
        return response()->json(Subscriber::all());
    }

    //
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:subscribers,email',
        ]);

        $subscriber = new Subscriber();
        $subscriber->email = $request->input('email');
        $subscriber->ip_address = $request->ip();
        $subscriber->user_agent = $request->header('User-Agent');
        $subscriber->device_type = $this->userAgentService->detectDevice($subscriber->user_agent);
        $subscriber->browser = $this->userAgentService->detectBrowser($subscriber->user_agent);
        $subscriber->os = $this->userAgentService->detectOS($subscriber->user_agent);
        $subscriber->location = $this->userAgentService->getLocationFromIP($subscriber->ip_address);
        $subscriber->save();

        return response()->json(['message' => 'Subscribed successfully!'], 201);
    }


    public function destroy($id)
    {
        $subscriber = Subscriber::find($id);
        if ($subscriber) {
            $subscriber->delete();
            return response()->json(['message' => 'Unsubscribed successfully!'], 200);
        } else {
            return response()->json(['message' => 'Subscriber not found!'], 404);
        }
    }

}
