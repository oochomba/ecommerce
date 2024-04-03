<?php

namespace App\Http\Controllers;

use App\Mail\ContactMail;
use App\Models\ContactModel;
use Illuminate\Http\Request;
use Mail;
use App\Jobs\ContactMailJob;
use Illuminate\Support\Facades\Artisan;
use Yoeunes\Toastr\Toastr;

class HomeController extends Controller
{
    var $data;
    //
    public function index()
    {
        $this->data['meta_title'] = 'Home';
        $this->data['meta_description'] = '';
        $this->data['meta_keywords'] = '';
        return view("layouts.fullpage", $this->data);
    }
    public function contact()
    {
        $this->data['meta_title'] = 'Contact Us';
        $this->data['meta_description'] = '';
        $this->data['meta_keywords'] = '';
        return view("contact", $this->data);
    }
    public function contact_post(Request $request)
    {
        $rules = [
            'name'     => 'required',
            'email'    => 'required|email',
            'subject' => 'required',
            'message' => 'required',
            'phone' => 'digits:10|numeric',
        ];

        $request->validate($rules, [
            'password.required'   => 'Please enter your name',
            'email.required'  => 'Please your email address',
            'subject.required'   => 'Please enter the email subject',
            'message.required'  => 'Please enter your message',
        ]);
        $contact = new ContactModel();
        $contact->name = trim($request->name);
        $contact->email = trim($request->email);
        $contact->phone = trim($request->phone);
        $contact->subject = trim($request->subject);
        $contact->message = trim($request->message);
        $contact->save();
        dispatch(new ContactMailJob($contact));
        // Mail::to(config('siteconfig.contacts.email.contact'))->queue(new ContactMail($contact));
        return redirect()->back()->with('success','Thank you for contacting us. We will get back to you shortly.');
    }
}
