<?php

namespace App\Http\Controllers\Vtt;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use DB;
use App\Models\Vtt\Profile;
use App\Models\Vtt\User;
use App\Models\Vtt\Bible;
use View;
use Carbon\Carbon;

class LoginController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if (Auth::check()) {
            // user is logged in
            dd("hello");
            $user_id = auth()->user()->id;
            $user = User::find($user_id);
            $store_id = auth()->user()->store_id;
        } else {
            // user is not logged in
            $bible = Bible::orderByRaw("RAND()")->first();
            $store_id = 1;
            $profile = Profile::where('id', $store_id)
                ->orderBy('created_at', 'desc')->first();

            return view('index')
                ->with('bibles', $bible)
                ->with('profiles', $profile);

            //return redirect()->guest(route('login'));
        }

        if ((Auth::user()->password_changed_at == null)) {
            return view('auth.reset-secured');
        } else {
            $bible = Bible::orderByRaw("RAND()")->first();
            $profile = Profile::where('id', $store_id)
                ->orderBy('created_at', 'desc')->first();

            if (View::exists('index')) {
                return view('index')
                    ->with('bibles', $bible)
                    ->with('profiles', $profile);
            } else {
                return 'No view available';
            }
        }
    }
}
