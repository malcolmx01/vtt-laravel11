<?php

namespace App\Http\Controllers\Vtt;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Vtt\Profile; //use the Model Profile
use App\Models\Vtt\Employee;

use Illuminate\Support\Facades\Storage; //to access the storage folder of images

class ProfilesController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
     public function __construct()
     {
         $this->middleware('auth', ['except'=>['index','show']]);
     }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $profile = Profile::orderBy('created_at','desc')->paginate(10);
        return view('vtt.pos.profiles.index')->with('profiles',$profile);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('vtt.pos.profiles.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'logo'=>'image|nullable|max:1999',
            'company'=>'required',
            'banner_image'=>'image|nullable|max:1999'
        ]);

        // Handle File Upload

        if($request->hasFile('banner_image')){
            //Get filename with the extension
            $filenameWithExt = $request->file('banner_image')->getClientOriginalName();
            //Get just filename
            $filename = pathinfo($filenameWithExt,PATHINFO_FILENAME);
            //Get just ext
            $extension = $request->file('banner_image')->getClientOriginalExtension();

            $fileNameToStore = $filename.'_'.time().".".$extension;
            // Upload Image
            $path = $request->file('banner_image')->storeAs('public/profile_image',$fileNameToStore);

        } else {
            $fileNameToStore = 'no_image.jpg';
        }

        if($request->hasFile('logo')){
            //Get filename with the extension
            $LogoWithExt = $request->file('logo')->getClientOriginalName();
            //Get just filename
            $LogoName = pathinfo($LogoWithExt,PATHINFO_FILENAME);
            //Get just ext
            $LogoExtension = $request->file('logo')->getClientOriginalExtension();

            $LogoNameToStore = $LogoName.'_'.time().".".$LogoExtension;
            // Upload Image
            $path = $request->file('logo')->storeAs('public/profile_image',$LogoNameToStore);

        } else {
            $LogoNameToStore = 'no_image.jpg';
        }

        // Create Profile
        $profile = new Profile;
        $profile->company = $request->input('company');
        $profile->services = $request->input('services');
        $profile->address1 = $request->input('address1');
        $profile->address2 = $request->input('address2');

        /*$profile->title = $request->input('title');
        $profile->profile = $request->input('profile');*/

        $static = $request->input('static');
        if ( $static  <> 1 ) { $static = 0; }
        $profile->static = $static;

        $public = $request->input('public');
        if ( $public  <> 1 ) { $public = 0; }
        $profile->public = $public;

        $profile->quote = $request->input('quote');
        $profile->source = $request->input('source');
        $profile->kick_off_date = $request->input('kick_off_date');

        $profile->banner_image = $fileNameToStore;
        $profile->logo = $LogoNameToStore;
        $profile->user_id = auth()->user()->id;

        $profile->save();

        $id = $profile->id;

        return redirect('/profiles/'.$id)->with('flash', 'Profile Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Profile $profile)
    {
//        dd($profile);
//        $profile = Profile::find($id);
        return view('vtt.pos.profiles.show')->with('profiles',$profile);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Profile $profile)
    {
//        dd($profile);
//        $profile = Profile::find($id);
        return view('vtt.pos.profiles.edit')->with('profiles',$profile);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Profile $profiledata)
    {

        $this->validate($request, [
            'logo'=>'image|nullable|max:1999',
            'company'=>'required',
            'banner_image'=>'image|nullable|max:1999'
        ]);

        // Handle File Upload
        if($request->hasFile('banner_image')){
            //Get filename with the extension
            $filenameWithExt = $request->file('banner_image')->getClientOriginalName();
            //Get just filename
            $filename = pathinfo($filenameWithExt,PATHINFO_FILENAME);
            //Get just ext
            $extension = $request->file('banner_image')->getClientOriginalExtension();

            $fileNameToStore = $filename.'_'.time().".".$extension;
            // Upload Image
            $path = $request->file('banner_image')->storeAs('public/profile_image',$fileNameToStore);
        }

        if($request->hasFile('logo')){
            //Get filename with the extension
            $LogoWithExt = $request->file('logo')->getClientOriginalName();
            //Get just filename
            $LogoName = pathinfo($LogoWithExt,PATHINFO_FILENAME);
            //Get just ext
            $LogoExtension = $request->file('logo')->getClientOriginalExtension();

            $LogoNameToStore = $LogoName.'_'.time().".".$LogoExtension;
            // Upload Image
            $path = $request->file('logo')->storeAs('public/profile_image',$LogoNameToStore);
        }

        // Create Profile
        $profile = Profile::find($profiledata->id);

        $profile->company = $request->input('company');
        $profile->services = $request->input('services');
        $profile->address1 = $request->input('address1');
        $profile->address2 = $request->input('address2');

        /*$profile->title = $request->input('title');
        $profile->profile = $request->input('profile');*/

        $static = $request->input('static');
        if ( $static  <> 1 ) { $static = 0; }
        $profile->static = $static;

        $public = $request->input('public');
        if ( $public  <> 1 ) { $public = 0; }
        $profile->public = $public;

        $profile->quote = $request->input('quote');
        $profile->source = $request->input('source');
        $profile->kick_off_date = $request->input('kick_off_date');

        if($request->hasFile('banner_image')){
            Storage::delete('public/profile_image/' . $profile->banner_image);
            $profile->banner_image = $fileNameToStore;
        }
        if($request->hasFile('logo')){
            Storage::delete('public/profile_image/' . $profile->logo);
            $profile->logo = $LogoNameToStore;
        }

        $profile->save();

        return redirect('/profiles')->with('flash', 'Profile Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $profile = Profile::find($id);
        if(auth()->user()->id !== $profile->user_id){
            return redirect('/profiles')->with('error','Unauthorized Page');
        }

        if($profile->banner_image != 'no_image.jpg'){
            // Delete Image
            Storage::delete('public/profile_image/'.$profile->banner_image);
        }
        $profile->delete();
        return redirect('/profiles')->with('flash','Profile Removed');
    }

    public function responder_validator($id)
    {

        $statusDtl = DB::table('employees')
            ->join('profiles', 'profiles.id', '=', 'employees.store_id')
            ->select('employees.avatar', 'employees.name', 'profiles.company', 'employees.status')
            ->where('employees.preview_id', $id)->get();

        return view('vtt.profiles.responder_validator')
            ->with('statusDtl', $statusDtl);
    }


}
