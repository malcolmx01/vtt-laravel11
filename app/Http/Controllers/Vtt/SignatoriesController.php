<?php

namespace App\Http\Controllers\Vtt;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Vtt\Signatory; //use the Model Signatory
use App\Models\Vtt\User;
use App\Models\Vtt\IdentificationCard;
use Image;
use Auth;
use Session;
use DB;

use Illuminate\Support\Facades\Storage; //to access the storage folder of images

class SignatoriesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    /*    public function __construct()
        {
            $this->middleware('auth', ['except'=>['index','show']]);
        }*/

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::check()) {
            $store_id = auth()->user()->store_id;
        } else {
            return redirect()->guest(route('login'));
        }

        /*$user_list = User::orderBy('id')->pluck('name','id');
        $signatories = Signatory::orderBy('id', 'asc')->get();*/

        return view('pos.signatories.index')
            /*->with('signatories',$signatories)*/
            ->with('store_id',$store_id);
            /*->with('user_list',$user_list);*/
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $companyProfile = DB::table('profiles')->get();
        $user_list = User::orderBy('id')->pluck('name','id');
        $identification_cards = IdentificationCard::orderBy('id')->pluck('identification_card','id');

        return view('pos.signatories.create')
            ->with('companyProfile', $companyProfile)
            ->with('identification_cards',$identification_cards)
            ->with('user_list',$user_list);
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
            'signature'=>'image|nullable|max:1999',
            'signatory'=>'required',
        ]);

        // Handle File Upload

        if($request->hasFile('signature')){
            //Get filename with the extension
            $LogoWithExt = $request->file('signature')->getClientOriginalName();
            //Get just filename
            $SignatureName = pathinfo($LogoWithExt,PATHINFO_FILENAME);
            //Get just ext
            $LogoExtension = $request->file('signature')->getClientOriginalExtension();

            $SignatureNameToStore = $SignatureName.'_'.time().".".$LogoExtension;
            // Upload Image
            $path = $request->file('signature')->storeAs('public/signatory_image',$SignatureNameToStore);

        } else {
            $SignatureNameToStore = 'no_signature.jpg';
        }


        // Create Signatory
        $signatories = new Signatory;

        if ($request->hasFile('attachment')) {
            $attachment = $request->file('attachment');
            $filename = time() . '.' . $attachment->getClientOriginalExtension();
            Image::make($attachment)->resize(1000, 1000)->save(public_path('storage/signatory_image/' . $filename));

            $signatories->attachment = $filename;
        }

        $signatories->signatory = $request->input('signatory');
        $signatories->title = $request->input('honorific');
        $signatories->designation = $request->input('designation');
        /*$signatories->ID_description = $request->input('ID_description');*/

        $signatories->ID_description = 'PRC ID';

        $signatories->ID_presented = $request->input('ID_presented');
        $signatories->ID_no = $request->input('ID_no');
        $signatories->access_id = $request->input('access_id');

        $signatories->signature = $SignatureNameToStore;

        $signatories->store_id = auth()->user()->store_id;
        $signatories->user_id = auth()->user()->id;
        $signatories->status = 1;

        if ( ! (!request('expiry_date') || trim(request('expiry_date')) == "") ) {
            $signatories->expiry_date = date("Y-m-d", strtotime(request('expiry_date')));
        }

        $signatories->save();
        $id = $signatories->id;

        return redirect('/signatories/'.$id)->with('success', 'Signatory Created');

        /*$signatories = Signatory::orderBy('signatories.signatory')->get();
        $companyProfile = DB::table('profiles')->get();
        $user_list = User::orderBy('id')->pluck('name','id');
        $identification_cards = IdentificationCard::orderBy('id')->pluck('identification_card','id');

        return redirect()->back()
            ->with('identification_cards',$identification_cards)
            ->with('signatories',$signatories)
            ->with('companyProfile', $companyProfile)
            ->with('user_list',$user_list)
            ->with('flash', 'Signatory has been created!');*/
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $companyProfile = DB::table('profiles')->get();
        $user_list = User::orderBy('id')->pluck('name','id');
        $identification_cards = IdentificationCard::orderBy('id')->pluck('identification_card','id');

        $signatories = Signatory::find($id);

        return view('pos.signatories.show')
            ->with('identification_cards',$identification_cards)
            ->with('signatories',$signatories)
            ->with('companyProfile', $companyProfile)
            ->with('user_list',$user_list);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $signatories = Signatory::find($id);
        $companyProfile = DB::table('profiles')->get();
        $user_list = User::orderBy('id')->pluck('name','id');
        $identification_cards = IdentificationCard::orderBy('id')->pluck('identification_card','id');

        return view('pos.signatories.edit')
            ->with('identification_cards',$identification_cards)
            ->with('signatories',$signatories)
            ->with('companyProfile', $companyProfile)
            ->with('user_list',$user_list);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'signature'=>'image|nullable|max:1999',
            'signatory'=>'required',
        ]);

        // Create Signatory
        $signatories = Signatory::find($id);

        if ($request->hasFile('signature')) {
            $signature = $request->file('signature');
            $filename = time() . '.' . $signature->getClientOriginalExtension();
            Image::make($signature)->resize(300, 300)->save(public_path('storage/signatory_image/' . $filename));

            $signatories->signature = $filename;
        }

        if ($request->hasFile('attachment')) {
            $attachment = $request->file('attachment');
            $filename = time() . '.' . $attachment->getClientOriginalExtension();
            Image::make($attachment)->resize(1000, 1000)->save(public_path('storage/signatory_image/' . $filename));

            $signatories->attachment = $filename;
        }

        $signatories->signatory = $request->input('signatory');
        $signatories->title = $request->input('honorific');
        $signatories->designation = $request->input('designation');
        /*$signatories->ID_description = $request->input('ID_description');*/

        $signatories->ID_description = 'PRC ID';

        $signatories->ID_presented = $request->input('ID_presented');
        $signatories->ID_no = $request->input('ID_no');
        $signatories->access_id = $request->input('access_id');

        $signatories->store_id = auth()->user()->store_id;
        $signatories->user_id = auth()->user()->id;
        $signatories->status = $request->input('status');

        if ( ! (!request('expiry_date') || trim(request('expiry_date')) == "") ) {
            $signatories->expiry_date = date("Y-m-d", strtotime(request('expiry_date')));
        }

        $signatories->save();

        return redirect('/signatories')->with('flash', 'Signatory Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $signatories = Signatory::find($id);

        $signatories->delete();
        return redirect('/signatories')->with('flash','Signatory Removed');
    }

    /**
     * Show the list of Signatories.
     *
     * @return \Illuminate\Http\Response
     */
    public function SignatoryList($id)
    {
        $signatories = DB::table('signatories')
            ->Leftjoin('identification_cards', 'signatories.ID_presented', '=', 'identification_cards.id')
            ->join('profiles', 'signatories.store_id', '=', 'profiles.id')
            ->select('signatories.*', 'profiles.address1', 'profiles.address1 as address1', 'profiles.address2 as address2','identification_cards.identification_card')
            ->get();

        $rows = Signatory::count();

        $meta = '{  
        "page": 1, 
        "pages": 1,
        "perpage": 10,     
        "total": ' . $rows . ',
        "sort": "asc",
        "field": "RecordID"
        }';

        $dataobject = json_decode($signatories);
        $object = json_decode('{}');
        $object->meta = json_decode($meta);
        $object->data = $dataobject;

        return response()->json($object, 200, [], JSON_PRETTY_PRINT); // arranged properly
    }

}
