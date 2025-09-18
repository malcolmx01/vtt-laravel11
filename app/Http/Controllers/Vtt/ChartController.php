<?php

namespace App\Http\Controllers\Vtt;

use App\Http\Controllers\Controller;

use App\Models\Diagnostics\AudioResult;
use Illuminate\Http\Request;
use Charts;
use App\Models\Vtt\Order;
use App\Models\Vtt\User;
use DB;
use Auth;
use PDF;

class ChartController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function audiometry_chart($order_id, $preview_id){

        $order = Order::with('client')
            ->where('id', $order_id)
            ->first();

        $audiometry_db_results=AudioResult::select('right_db1', 'right_db2', 'right_db3', 'right_db4', 'right_db5', 'left_db1', 'left_db2', 'left_db3', 'left_db4', 'left_db5')
            ->where('or_no',$order_id)->get();

        $audiometry_hz_results=AudioResult::select('right_hz1', 'right_hz2', 'right_hz3', 'right_hz4', 'right_hz5', 'left_hz1', 'left_hz2', 'left_hz3', 'left_hz4', 'left_hz5')
            ->where('or_no',$order_id)->get();

        $right_ear_results=AudioResult::selectRaw("(right_db1 + right_db2 + right_db3 + right_db4 + right_db5)/5 as right_result, right_ear_result.results_description as right_ear_results_description")
            ->leftJoin('audio_results as right_ear_result',[[DB::raw("(right_db1 + right_db2 + right_db3 + right_db4 + right_db5)/5"),'>=','right_ear_result.from'], [DB::raw("(right_db1 + right_db2 + right_db3 + right_db4 + right_db5)/5"),'<=','right_ear_result.to']] )
            ->where('or_no',$order_id)->first();

        $left_ear_results=AudioResult::selectRaw("(left_db1 + left_db2 + left_db3 + left_db4 + left_db5)/5 as left_result, left_ear_result.results_description as left_ear_results_description")
            ->leftJoin('audio_results as left_ear_result',[[DB::raw("(left_db1 + left_db2 + left_db3 + left_db4 + left_db5)/5"),'>=','left_ear_result.from'], [DB::raw("(left_db1 + left_db2 + left_db3 + left_db4 + left_db5)/5"),'<=','left_ear_result.to']] )
            ->where('or_no',$order_id)->first();

        $right_ear_results = "(".(int)$right_ear_results->right_result.") ".$right_ear_results->right_ear_results_description;
        $left_ear_results = "(".(int)$left_ear_results->left_result.") ".$left_ear_results->left_ear_results_description;

        $right_ear_interpretation = $right_ear_results->right_ear_results_description;
        $left_ear_interpretation = $left_ear_results->left_ear_results_description;

        $right_hzs=array();
        $left_hzs=array();

        foreach ($audiometry_db_results as $result) {
            $right_hzs[$audiometry_hz_results[0]->right_hz1]=(int)$result->right_db1;
            $right_hzs[$audiometry_hz_results[0]->right_hz2]=(int)$result->right_db2;
            $right_hzs[$audiometry_hz_results[0]->right_hz3]=(int)$result->right_db3;
            $right_hzs[$audiometry_hz_results[0]->right_hz4]=(int)$result->right_db4;
            $right_hzs[$audiometry_hz_results[0]->right_hz5]=(int)$result->right_db5;

            $left_hzs[$audiometry_hz_results[0]->left_hz1]=(int)$result->left_db1;
            $left_hzs[$audiometry_hz_results[0]->left_hz2]=(int)$result->left_db2;
            $left_hzs[$audiometry_hz_results[0]->left_hz3]=(int)$result->left_db3;
            $left_hzs[$audiometry_hz_results[0]->left_hz4]=(int)$result->left_db4;
            $left_hzs[$audiometry_hz_results[0]->left_hz5]=(int)$result->left_db5;
        }

        return view('diagnostics.forms.audiometry_chart',compact('right_hzs'), compact('left_hzs'))
            ->with('order_id',$order_id)
            ->with('preview_id',$preview_id)
            ->with('right_ear_results',$right_ear_results)
            ->with('left_ear_results',$left_ear_results)
            ->with('order',$order)
            ->with('right_ear_interpretation',$right_ear_interpretation)
            ->with('left_ear_interpretation',$left_ear_interpretation);
    }


    public function AudioChartPrintPreview($order_id, $preview_id){
        if (Auth::check()) {
            // user is logged in
            $store_id = auth()->user()->store_id;
        } else {
            return redirect()->guest(route('login'));
        }

        $resultsDtl = DB::table('diagnostic_view')
            ->leftjoin('signatories as a', 'diagnostic_view.performed_by', 'a.access_id')
            ->leftjoin('signatories as b', 'diagnostic_view.approved_by', 'b.access_id')
            ->select('diagnostic_view.*', 'a.signatory as performed_by', 'b.signatory as approved_by','b.title as title', 'b.designation as designation1', 'b.ID_description as ID1', 'b.ID_no as ID_no1', 'b.expiry_date as ID_expiry1', 'b.signature as signature1')
            ->where('diagnostic_view.store_id', $store_id)
            ->where('diagnostic_view.preview_id', $preview_id)
            ->first();

        if ($resultsDtl) {

//      Signature
            if (!empty($resultsDtl->signature1)) {
                $signature1 = 'storage/signatory_image/' . $resultsDtl->signature1;
                if (@file_get_contents($signature1)) {
                    $signature1_data = file_get_contents($signature1);
                    $extension = pathinfo($signature1, PATHINFO_EXTENSION);
                    $signature1_base_64 = base64_encode($signature1_data);
                    $signature1_img = 'data:image/' . $extension . ';base64,' . $signature1_base_64;
                    $resultsDtl->signature1 = $signature1_img;
                }
            }
        }

        $audiometry_db_results=AudioResult::select('right_db1', 'right_db2', 'right_db3', 'right_db4', 'right_db5', 'left_db1', 'left_db2', 'left_db3', 'left_db4', 'left_db5')
            ->where('or_no',$order_id)->get();

        $audiometry_hz_results=AudioResult::select('right_hz1', 'right_hz2', 'right_hz3', 'right_hz4', 'right_hz5', 'left_hz1', 'left_hz2', 'left_hz3', 'left_hz4', 'left_hz5')
            ->where('or_no',$order_id)->get();

        $right_ear_results=AudioResult::selectRaw("(right_db1 + right_db2 + right_db3 + right_db4 + right_db5)/5 as right_result, right_ear_result.results_description as right_ear_results_description")
            ->leftJoin('audio_results as right_ear_result',[[DB::raw("(right_db1 + right_db2 + right_db3 + right_db4 + right_db5)/5"),'>=','right_ear_result.from'], [DB::raw("(right_db1 + right_db2 + right_db3 + right_db4 + right_db5)/5"),'<=','right_ear_result.to']] )
            ->where('or_no',$order_id)->first();

        $left_ear_results=AudioResult::selectRaw("(left_db1 + left_db2 + left_db3 + left_db4 + left_db5)/5 as left_result, left_ear_result.results_description as left_ear_results_description")
            ->leftJoin('audio_results as left_ear_result',[[DB::raw("(left_db1 + left_db2 + left_db3 + left_db4 + left_db5)/5"),'>=','left_ear_result.from'], [DB::raw("(left_db1 + left_db2 + left_db3 + left_db4 + left_db5)/5"),'<=','left_ear_result.to']] )
            ->where('or_no',$order_id)->first();

        $right_ear_interpretation = $right_ear_results->right_ear_results_description;
        $left_ear_interpretation = $left_ear_results->left_ear_results_description;

        $right_ear_results = "(".(int)$right_ear_results->right_result.") ".$right_ear_results->right_ear_results_description;
        $left_ear_results = "(".(int)$left_ear_results->left_result.") ".$left_ear_results->left_ear_results_description;

        /*dd($right_ear_interpretation);*/

        $right_hzs=array();
        $left_hzs=array();

        foreach ($audiometry_db_results as $result) {
            $right_hzs[$audiometry_hz_results[0]->right_hz1]=(int)$result->right_db1;
            $right_hzs[$audiometry_hz_results[0]->right_hz2]=(int)$result->right_db2;
            $right_hzs[$audiometry_hz_results[0]->right_hz3]=(int)$result->right_db3;
            $right_hzs[$audiometry_hz_results[0]->right_hz4]=(int)$result->right_db4;
            $right_hzs[$audiometry_hz_results[0]->right_hz5]=(int)$result->right_db5;

            $left_hzs[$audiometry_hz_results[0]->left_hz1]=(int)$result->left_db1;
            $left_hzs[$audiometry_hz_results[0]->left_hz2]=(int)$result->left_db2;
            $left_hzs[$audiometry_hz_results[0]->left_hz3]=(int)$result->left_db3;
            $left_hzs[$audiometry_hz_results[0]->left_hz4]=(int)$result->left_db4;
            $left_hzs[$audiometry_hz_results[0]->left_hz5]=(int)$result->left_db5;
        }

        if ($resultsDtl) {
            return view('diagnostics.forms.AudiometryResults',compact('right_hzs'), compact('left_hzs'))
                ->with('resultsDtl', $resultsDtl)
                ->with('preview_id',$preview_id)
                ->with('order_id',$order_id)
                ->with('right_ear_results',$right_ear_results)
                ->with('left_ear_results',$left_ear_results)
                ->with('right_ear_interpretation',$right_ear_interpretation)
                ->with('left_ear_interpretation',$left_ear_interpretation);
        } else {
            return view('pos.resultsPrintPreviewUnavailable');
        }

    }

}
