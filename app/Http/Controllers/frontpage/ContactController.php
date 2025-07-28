<?php

namespace App\Http\Controllers\frontpage;

use Illuminate\Http\Request;
use App\Models\admin\Contact;
use App\Models\Subscriber;
use App\Http\Controllers\Controller;
use App\Mail\SubscribeMail;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function index()
    {
        $data = Contact::get()->toArray();

        $data = array_column($data, 'value', 'name');

        return view('frontpage.contact.index', compact('data'));
    }
    public function subscribe(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:subscribers,email',
        ]);

        Subscriber::create([
            'email' => $request->email,
        ]);

        // Send email
        Mail::to($request->email)->send(new SubscribeMail($request->email));

        return redirect()->back()->with('success', 'Thank you for subscribing!');
    }

    public function unsubscribe(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:subscribers,email',
        ]);

        Subscriber::where('email', $request->email)->delete();

        return view('frontpage.home.index')->with('success', 'Thank you for unsubscribing!');
    }
}
