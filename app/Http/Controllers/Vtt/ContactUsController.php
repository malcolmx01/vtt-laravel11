<?php

namespace App\Http\Controllers\Vtt;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage; //to access the storage folder of images
use Illuminate\Mail\Mailer;
use Illuminate\Http\Request;
//use App\Models\Inventory\Http\Requests;
use App\Models\Vtt\ContactUs;

class ContactUsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
   * Show the application dashboard.
   *
   * @return \Illuminate\Http\Response
   */
  public function contactUs()
  {
      return view('contactus.contact');
  }

  /**
   * Show the application dashboard.
   *
   * @return \Illuminate\Http\Response
   */

   public function contactUsPost(Request $request)
   {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email',
            'message' => 'required'
            ]);

        // Create Client
        $contactus = new ContactUs;
        $contactus->name = $request->input('name');
        $contactus->email = $request->input('email');
        $contactus->message = $request->input('message');

        $contactus->save();

        \Mail::send('email',
        array(
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'user_message' => $request->get('message')
        ), function($message)
   {
        $message->from('jolex29@yahoo.com');
        $message->to('jolex29@gmail.com', 'Admin')->subject('DDSV Feedback');
   });
    return redirect('/contact')->with('success', 'Thanks for contacting us!');
   }

  public function WorkingContactUsPost(Request $request)
  {
      $this->validate($request, [
       'name' => 'required',
       'email' => 'required|email',
       'message' => 'required'
       ]);

    // Create Client
    $contactus = new ContactUs;
    $contactus->name = $request->input('name');
    $contactus->email = $request->input('email');
    $contactus->message = $request->input('message');

    $contactus->save();

    // ContactUs::create($request->all());

    // return back()->with('success', 'Thanks for contacting us!');

    return redirect('/contact')->with('success', 'Thank you for contacting us!');
  }

  public function show($id)
  {
      $contactus = ContactUs::find($id);
      return view('contactus.show')->with('contactus',$contactus);
  }

}
