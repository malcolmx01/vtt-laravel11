<?php

namespace App\Http\Controllers\Vtt;

use App\Http\Controllers\Controller;
use Session;
use DB;
use App\Models\Vtt\Region;
use App\Models\Vtt\Province;
use App\Models\Vtt\Citymun;
use App\Models\Vtt\Barangay;
use Hash;
use Input;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Response;

class LGUsController extends Controller
{
    public function searchBarangay(Request $request)
    {
        $searchKey = $request->input('term');

        $results = [];

        $queries = DB::table('barangays')
            ->where('BARANGAY', 'LIKE', '%'.$searchKey.'%')
            ->take(5)->get();

        foreach ($queries as $query) {
            $results[] = ['id' => $query->BARANGAY_C, 'value' => $query->BARANGAY];
        }

        return Response::json($results);
    }

    public function listBarangay(Request $request)
    {
        $data = DB::table('barangays')
            ->select('barangays.BARANGAY_C','barangays.BARANGAY', 'barangays.PROVINCE_C', 'barangays.REGION_C', 'citymuns.CITYMUN', "provinces.PROVINCE AS province" )
            ->join('citymuns', function ($join) {
                $join->on('barangays.REGION_C', 'citymuns.REGION_C')
                    ->on('barangays.PROVINCE_C', 'citymuns.PROVINCE_C')
                    ->on('barangays.CITYMUN_C', 'citymuns.CITYMUN_C');
            })
            ->join('provinces', function ($join) {
                $join->on('barangays.REGION_C', 'provinces.REGION_C')
                    ->on('barangays.PROVINCE_C', 'provinces.PROVINCE_C');
            })
            ->where('citymuns.CITYMUN_C',$request->id)
            ->get();

        return response()->json($data);
    }

    public function listProvince(Request $request){

        if ($request->id == 0) {  // all provinces
            $data=Province::select('PROVINCE','PROVINCE_C')->get();
        } else {
            $data=Province::select('PROVINCE','PROVINCE_C')->where('REGION_C',$request->id)->get();
        }
        return response()->json($data);
    }

    public function listCityMunicipality(Request $request){

        $t = DB::table('provinces')
            ->join('citymuns', 'provinces.PROVINCE_C', '=', 'citymuns.PROVINCE_C')
            ->select('citymuns.CITYMUN_C', 'citymuns.CITYMUN', 'citymuns.PROVINCE_C', 'citymuns.REGION_C', 'provinces.PROVINCE as PROVINCE')
            ->where('provinces.PROVINCE_C',$request->id)->get();

        return response()->json($t);//then sent this data to ajax success
    }

    public function setRegionProvince(Request $request){

        $data=Citymun::select('REGION_C','PROVINCE_C')->where('id',$request->id)->get();

        return response()->json($data);
    }
}
