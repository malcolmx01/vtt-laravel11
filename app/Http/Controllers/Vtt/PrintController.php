<?php

namespace App\Http\Controllers\Vtt;

use App\Http\Controllers\Controller;
use Auth;
use DB;
use PDF;
use App\Models\Diagnostics\Laboratory_test_result;
use App\Models\Vtt\Order;
use App\Models\Vtt\OrderDetail;
use App\Models\Vtt\Partner;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class printController extends Controller
{
    public function ConsolidatedLabResults($id, $preview_id, $tests){
        if (Auth::check()) {
            // user is logged in
            $store_id = auth()->user()->store_id;
        } else {
            return redirect()->guest(route('login'));
        }

        $tests = explode(',', $tests);

        $testResult = Laboratory_test_result::with('referenceValue','subclassification')
            ->where('or_no', $id)
            ->whereIn('item_id', $tests)
            ->get();

        $order = OrderDetail::with('item')->where('order_id', $id)->whereIn('item_id', $tests)->get();

        $resultsDtl = DB::table('diagnostic_view')

            /*->join('diagnostic_view', 'diagnostic_view.or_no', '=', 'orders.id')*/
            ->leftjoin('signatories as a', 'diagnostic_view.performed_by', 'a.access_id')
            ->leftjoin('signatories as b', 'diagnostic_view.approved_by', 'b.access_id')
            ->select('diagnostic_view.avatar', 'diagnostic_view.name', 'diagnostic_view.suffix', 'diagnostic_view.gender', 'diagnostic_view.age', 'diagnostic_view.birthday', 'diagnostic_view.civil_status',  'diagnostic_view.telno', 'diagnostic_view.mobile_no', 'diagnostic_view.email', 'diagnostic_view.ID_presented', 'diagnostic_view.ID_no', 'diagnostic_view.address', 'diagnostic_view.referring_institution', 'diagnostic_view.pdf', 'diagnostic_view.preview_id', 'diagnostic_view.remarks',  'diagnostic_view.others','diagnostic_view.med_cert_date_issued', 'a.signatory as performed_by','b.signatory as approved_by','a.title as title','b.title as title2', 'a.designation as designation1', 'b.designation as designation2', 'a.ID_description as ID1', 'b.ID_description as ID2', 'a.ID_no as ID_no1', 'b.ID_no as ID_no2','a.expiry_date as ID_expiry1', 'b.expiry_date as ID_expiry2', 'a.signature as signature1', 'b.signature as signature2')
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

            if (!empty($resultsDtl->signature2)) {
                $signature2 = 'storage/signatory_image/' . $resultsDtl->signature2;
                if (@file_get_contents($signature2)) {
                    $signature2_data = file_get_contents($signature2);
                    $extension = pathinfo($signature2, PATHINFO_EXTENSION);
                    $signature2_base_64 = base64_encode($signature2_data);
                    $signature2_img = 'data:image/' . $extension . ';base64,' . $signature2_base_64;
                    $resultsDtl->signature2 = $signature2_img;
                }
            }

            $customPaper = array(0, 0, 612.00, (792.00));
            $pdf = PDF::loadView('diagnostics.forms.ConsolidatedLabResults', array('order'=>$order, 'testResult' => $testResult, 'resultsDtl' => $resultsDtl));
            Storage::put('public/results_pdf/'.$resultsDtl->pdf, $pdf->output());
            //$pdffile = preg_replace('/[^A-Za-z0-9\-]/', '_', $resultsDtl->name) . '.pdf';
            $pdf->setPaper($customPaper);
            return $pdf->stream();
        } else {
            return view('pos.resultsPrintPreviewUnavailable');
        }
    }

    public function GenericLabResults($id, $preview_id){
        if (Auth::check()) {
            // user is logged in
            $store_id = auth()->user()->store_id;
        } else {
            return redirect()->guest(route('login'));
        }

        $testResult = Laboratory_test_result::with('referenceValue','subclassification')
            ->where('or_no', $id)->get();
            /*->orderBy('item_id')
            ->groupBy('item_id')->get();*/


        $order = OrderDetail::with('item')->where('order_id', $id)->get();

        //$orderDetails = OrderDetail::with('items.item_reference.laboratory_reference_value')->where('order_id', $id)->get();

        //dd($order[0]->detail[0]->item_id);

        $resultsDtl = DB::table('diagnostic_view')

            /*->join('diagnostic_view', 'diagnostic_view.or_no', '=', 'orders.id')*/
            ->leftjoin('signatories as a', 'diagnostic_view.performed_by', 'a.access_id')
            ->leftjoin('signatories as b', 'diagnostic_view.approved_by', 'b.access_id')
            ->select('diagnostic_view.avatar', 'diagnostic_view.name', 'diagnostic_view.suffix', 'diagnostic_view.gender', 'diagnostic_view.age', 'diagnostic_view.birthday', 'diagnostic_view.civil_status',  'diagnostic_view.telno', 'diagnostic_view.mobile_no', 'diagnostic_view.email', 'diagnostic_view.ID_presented', 'diagnostic_view.ID_no', 'diagnostic_view.address', 'diagnostic_view.referring_institution', 'diagnostic_view.pdf', 'diagnostic_view.preview_id', 'diagnostic_view.remarks',  'diagnostic_view.others','diagnostic_view.med_cert_date_issued', 'a.signatory as performed_by','b.signatory as approved_by','a.title as title','b.title as title2', 'a.designation as designation1', 'b.designation as designation2', 'a.ID_description as ID1', 'b.ID_description as ID2', 'a.ID_no as ID_no1', 'b.ID_no as ID_no2','a.expiry_date as ID_expiry1', 'b.expiry_date as ID_expiry2', 'a.signature as signature1', 'b.signature as signature2')
            ->where('diagnostic_view.store_id', $store_id)
            ->where('diagnostic_view.preview_id', $preview_id)
            ->first();

        if ($testResult) {

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

            if (!empty($resultsDtl->signature2)) {
                $signature2 = 'storage/signatory_image/' . $resultsDtl->signature2;
                if (@file_get_contents($signature2)) {
                    $signature2_data = file_get_contents($signature2);
                    $extension = pathinfo($signature2, PATHINFO_EXTENSION);
                    $signature2_base_64 = base64_encode($signature2_data);
                    $signature2_img = 'data:image/' . $extension . ';base64,' . $signature2_base_64;
                    $resultsDtl->signature2 = $signature2_img;
                }
            }

            $customPaper = array(0, 0, 612.00, (792.00));
            $pdf = PDF::loadView('diagnostics.forms.GenericLabResults', array('order'=>$order, 'testResult' => $testResult, 'resultsDtl' => $resultsDtl));
            Storage::put('public/results_pdf/'.$resultsDtl->pdf, $pdf->output());
            //$pdffile = preg_replace('/[^A-Za-z0-9\-]/', '_', $resultsDtl->name) . '.pdf';
            $pdf->setPaper($customPaper);
            return $pdf->stream();
        } else {
            return view('pos.resultsPrintPreviewUnavailable');
        }
    }

    public function LabResults($id, $rid, $pid, $preview_id){
        if (Auth::check()) {
            // user is logged in
            $store_id = auth()->user()->store_id;
        } else {
            return redirect()->guest(route('login'));
        }

        $testResult = Laboratory_test_result::with('referenceValue','subclassification')->where('or_no', $id)->where('item_id', $pid)->get();


        $resultsDtl = DB::table('diagnostic_view')

            ->join('laboratory_test_results', [['diagnostic_view.or_no', 'laboratory_test_results.or_no'], ['diagnostic_view.sub_classification_id', 'laboratory_test_results.sub_classification_id'],
        ['diagnostic_view.item_id', 'laboratory_test_results.item_id']])
            ->leftjoin('signatories as a', 'diagnostic_view.performed_by', 'a.access_id')
            ->leftjoin('signatories as b', 'diagnostic_view.approved_by', 'b.access_id')
            ->select('diagnostic_view.avatar', 'diagnostic_view.name', 'diagnostic_view.suffix', 'diagnostic_view.gender', 'diagnostic_view.age', 'diagnostic_view.birthday', 'diagnostic_view.civil_status',  'diagnostic_view.telno', 'diagnostic_view.mobile_no', 'diagnostic_view.email', 'diagnostic_view.ID_presented', 'diagnostic_view.ID_no', 'diagnostic_view.address', 'diagnostic_view.referring_institution',  'laboratory_test_results.lab_result as results', 'laboratory_test_results.result_desc','diagnostic_view.pdf', 'diagnostic_view.preview_id', 'diagnostic_view.remarks',  'diagnostic_view.others','diagnostic_view.med_cert_date_issued', 'a.signatory as performed_by','b.signatory as approved_by','a.title as title','b.title as title2', 'a.designation as designation1', 'b.designation as designation2', 'a.ID_description as ID1', 'b.ID_description as ID2', 'a.ID_no as ID_no1', 'b.ID_no as ID_no2','a.expiry_date as ID_expiry1', 'b.expiry_date as ID_expiry2', 'a.signature as signature1', 'b.signature as signature2')
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

            if (!empty($resultsDtl->signature2)) {
                $signature2 = 'storage/signatory_image/' . $resultsDtl->signature2;
                if (@file_get_contents($signature2)) {
                    $signature2_data = file_get_contents($signature2);
                    $extension = pathinfo($signature2, PATHINFO_EXTENSION);
                    $signature2_base_64 = base64_encode($signature2_data);
                    $signature2_img = 'data:image/' . $extension . ';base64,' . $signature2_base_64;
                    $resultsDtl->signature2 = $signature2_img;
                }
            }

            $cntResult = Laboratory_test_result::where('or_no', $id)->where('item_id', $pid)->count();

            if (empty($cntResult)) $testResult = false;

            $order = Order::with('detail.item', 'client', 'detail')
                ->whereHas('client', function ($q) {
                    $q->whereNotNull('id');
                })
                ->where('id', $id)
                ->first();

            $orderDetails = OrderDetail::with('items.item_reference.laboratory_reference_value')->where('id', $rid)->first();

            $customPaper = array(0, 0, 612.00, (792.00));
            $pdf = PDF::loadView('diagnostics.forms.LabResults', array('order'=>$order, 'resultsDtl' => $resultsDtl, 'testResult' => $testResult, 'details' => $orderDetails));
            Storage::put('public/results_pdf/'.$resultsDtl->pdf, $pdf->output());
            //$pdffile = preg_replace('/[^A-Za-z0-9\-]/', '_', $resultsDtl->name) . '.pdf';
            $pdf->setPaper($customPaper);
            return $pdf->stream();
        } else {
            return view('pos.resultsPrintPreviewUnavailable');
        }
    }

    public function IshiharaResultsPreview($preview_id)
    {
        if (Auth::check()) {
            $store_id = auth()->user()->store_id;
            $user_class = auth()->user()->class;
        } else {
            $store_id = "1";
        }

        // save as PDF

        $resultsDtl = DB::table('diagnostic_view')

            ->join('laboratory_test_results', [['diagnostic_view.or_no', 'laboratory_test_results.or_no'], ['diagnostic_view.sub_classification_id', 'laboratory_test_results.sub_classification_id'], ['diagnostic_view.item_id', 'laboratory_test_results.item_id']])
            ->leftjoin('signatories as a', 'diagnostic_view.approved_by', 'a.access_id')
            ->select('diagnostic_view.avatar', 'diagnostic_view.name', 'diagnostic_view.suffix', 'diagnostic_view.gender', 'diagnostic_view.age', 'diagnostic_view.birthday', 'diagnostic_view.civil_status',  'diagnostic_view.telno', 'diagnostic_view.mobile_no', 'diagnostic_view.email', 'diagnostic_view.ID_presented', 'diagnostic_view.ID_no', 'diagnostic_view.address', 'diagnostic_view.referring_institution',  'laboratory_test_results.lab_result as results', 'laboratory_test_results.result_desc','diagnostic_view.pdf', 'diagnostic_view.preview_id', 'diagnostic_view.med_exam_date', 'a.signatory as approved_by','a.title as title', 'a.designation as designation1', 'a.ID_description as ID1', 'a.ID_no as ID_no1', 'a.expiry_date as ID_expiry1', 'a.signature as signature1')
            ->where('diagnostic_view.store_id', $store_id)
            ->where('diagnostic_view.preview_id', $preview_id)
            ->get();

        if ($resultsDtl->count() > 0) {
            $companyProfile = DB::table('profiles')
                ->where('profiles.id', $store_id )->get();

//      Signature
            /*if(!empty($resultsDtl[0]->signature1)){
                $signature1 = 'storage/signatory_image/'.$resultsDtl[0]->signature1;
                if(@file_get_contents($signature1)){
                    $signature1_data = file_get_contents($signature1);
                    $extension = pathinfo($signature1, PATHINFO_EXTENSION);
                    $signature1_base_64 = base64_encode($signature1_data);
                    $signature1_img = 'data:image/' . $extension . ';base64,' . $signature1_base_64;
                    $resultsDtl[0]->signature1 = $signature1_img;
                }
            }*/


            $customPaper = array(0, 0, 612.00, (792.00));
            $pdf = PDF::loadView('diagnostics.forms.IshiharaResults', array('resultsDtl' => $resultsDtl, 'companyProfile' => $companyProfile));
            Storage::put('public/results_pdf/'.$resultsDtl[0]->pdf, $pdf->output());

            $pdf->setPaper($customPaper);
            return $pdf->stream();

        } else {
            return view('pos.resultsPrintPreviewUnavailable');
        }

    }

    public function HIVResultsPreview($preview_id)
    {
        if (Auth::check()) {
            $store_id = auth()->user()->store_id;
            $user_class = auth()->user()->class;
        } else {
            $store_id = "1";
        }

        // save as PDF

        $resultsDtl = DB::table('diagnostic_view')

            ->join('laboratory_test_results', [['diagnostic_view.or_no', 'laboratory_test_results.or_no'], ['diagnostic_view.sub_classification_id', 'laboratory_test_results.sub_classification_id'], ['diagnostic_view.item_id', 'laboratory_test_results.item_id']])
            ->leftjoin('signatories as a', 'diagnostic_view.performed_by', 'a.access_id')
            ->leftjoin('signatories as b', 'diagnostic_view.approved_by', 'b.access_id')
            ->select('diagnostic_view.avatar', 'diagnostic_view.name', 'diagnostic_view.suffix', 'diagnostic_view.gender', 'diagnostic_view.age', 'diagnostic_view.birthday', 'diagnostic_view.civil_status',  'diagnostic_view.telno', 'diagnostic_view.mobile_no', 'diagnostic_view.email', 'diagnostic_view.ID_presented', 'diagnostic_view.ID_no', 'diagnostic_view.address', 'diagnostic_view.referring_institution',  'laboratory_test_results.lab_result as results', 'laboratory_test_results.result_desc','diagnostic_view.pdf', 'diagnostic_view.preview_id', 'diagnostic_view.remarks', 'diagnostic_view.methodology', 'diagnostic_view.others','diagnostic_view.med_cert_date_issued', 'a.signatory as performed_by','b.signatory as approved_by','a.title as title','b.title as title2', 'a.designation as designation1', 'b.designation as designation2', 'a.ID_description as ID1', 'b.ID_description as ID2', 'a.ID_no as ID_no1', 'b.ID_no as ID_no2','a.expiry_date as ID_expiry1', 'b.expiry_date as ID_expiry2', 'a.signature as signature1', 'b.signature as signature2')
            ->where('diagnostic_view.store_id', $store_id)
            ->where('diagnostic_view.preview_id', $preview_id)
            ->get();

        //dd($resultsDtl);

        if ($resultsDtl->count() > 0) {
            $companyProfile = DB::table('profiles')
                ->where('profiles.id', $store_id )->get();

//      Signature
            if(!empty($resultsDtl[0]->signature1)){
                $signature1 = 'storage/signatory_image/'.$resultsDtl[0]->signature1;
                if(@file_get_contents($signature1)){
                    $signature1_data = file_get_contents($signature1);
                    $extension = pathinfo($signature1, PATHINFO_EXTENSION);
                    $signature1_base_64 = base64_encode($signature1_data);
                    $signature1_img = 'data:image/' . $extension . ';base64,' . $signature1_base_64;
                    $resultsDtl[0]->signature1 = $signature1_img;
                }
            }

            if(!empty($resultsDtl[0]->signature2)){
                $signature2 = 'storage/signatory_image/'.$resultsDtl[0]->signature2;
                if(@file_get_contents($signature2)){
                    $signature2_data = file_get_contents($signature2);
                    $extension = pathinfo($signature2, PATHINFO_EXTENSION);
                    $signature2_base_64 = base64_encode($signature2_data);
                    $signature2_img = 'data:image/' . $extension . ';base64,' . $signature2_base_64;
                    $resultsDtl[0]->signature2 = $signature2_img;
                }
            }

            $customPaper = array(0, 0, 612.00, (792.00));
            $pdf = PDF::loadView('diagnostics.forms.HIVResults', array('resultsDtl' => $resultsDtl, 'companyProfile' => $companyProfile));
            Storage::put('public/results_pdf/'.$resultsDtl[0]->pdf, $pdf->output());
            $pdffile = preg_replace('/[^A-Za-z0-9\-]/', '_', $resultsDtl[0]->name) . '.pdf';
            /*$pdf->setPaper($customPaper);
            return $pdf->stream();*/

            return view('diagnostics.forms.PDFResults')
                ->with('resultsDtl', $resultsDtl)
                ->with('pdffile', $pdffile);
        } else {
            return view('pos.resultsPrintPreviewUnavailable');
        }

    }

    public function XRayResultsPreview($preview_id)
    {
        if (Auth::check()) {
            $store_id = auth()->user()->store_id;
            $user_class = auth()->user()->class;
        } else {
            $store_id = "1";
        }

        // save as PDF

        $resultsDtl = DB::table('diagnostic_view')

            ->join('laboratory_test_results', [['diagnostic_view.or_no', 'laboratory_test_results.or_no'], ['diagnostic_view.sub_classification_id', 'laboratory_test_results.sub_classification_id'], ['diagnostic_view.item_id', 'laboratory_test_results.item_id']])
            ->leftjoin('signatories as a', 'diagnostic_view.performed_by', 'a.access_id')
            ->leftjoin('signatories as b', 'diagnostic_view.approved_by', 'b.access_id')
            ->select('diagnostic_view.avatar', 'diagnostic_view.name', 'diagnostic_view.suffix', 'diagnostic_view.gender', 'diagnostic_view.age', 'diagnostic_view.birthday', 'diagnostic_view.civil_status',  'diagnostic_view.telno', 'diagnostic_view.mobile_no', 'diagnostic_view.email', 'diagnostic_view.ID_presented', 'diagnostic_view.ID_no', 'diagnostic_view.address', 'diagnostic_view.referring_institution', 'laboratory_test_results.lab_result as examination', 'diagnostic_view.results as results', 'diagnostic_view.pdf', 'diagnostic_view.preview_id', 'diagnostic_view.remarks',  'diagnostic_view.others', 'diagnostic_view.impression', 'diagnostic_view.med_cert_date_issued', 'a.signatory as performed_by','b.signatory as approved_by','a.title as title','b.title as title2', 'a.designation as designation1', 'b.designation as designation2', 'a.ID_description as ID1', 'b.ID_description as ID2', 'a.ID_no as ID_no1', 'b.ID_no as ID_no2','a.expiry_date as ID_expiry1', 'b.expiry_date as ID_expiry2', 'a.signature as signature1', 'b.signature as signature2')
            ->where('diagnostic_view.store_id', $store_id)
            ->where('diagnostic_view.preview_id', $preview_id)
            ->get();

        //dd($resultsDtl);

        if ($resultsDtl->count() > 0) {
            $companyProfile = DB::table('profiles')
                ->where('profiles.id', $store_id )->get();

//      Signature
            if(!empty($resultsDtl[0]->signature1)){
                $signature1 = 'storage/signatory_image/'.$resultsDtl[0]->signature1;
                if(@file_get_contents($signature1)){
                    $signature1_data = file_get_contents($signature1);
                    $extension = pathinfo($signature1, PATHINFO_EXTENSION);
                    $signature1_base_64 = base64_encode($signature1_data);
                    $signature1_img = 'data:image/' . $extension . ';base64,' . $signature1_base_64;
                    $resultsDtl[0]->signature1 = $signature1_img;
                }
            }

            if(!empty($resultsDtl[0]->signature2)){
                $signature2 = 'storage/signatory_image/'.$resultsDtl[0]->signature2;
                if(@file_get_contents($signature2)){
                    $signature2_data = file_get_contents($signature2);
                    $extension = pathinfo($signature2, PATHINFO_EXTENSION);
                    $signature2_base_64 = base64_encode($signature2_data);
                    $signature2_img = 'data:image/' . $extension . ';base64,' . $signature2_base_64;
                    $resultsDtl[0]->signature2 = $signature2_img;
                }
            }

            $customPaper = array(0, 0, 612.00, (792.00));
            $pdf = PDF::loadView('diagnostics.forms.XRayResults', array('resultsDtl' => $resultsDtl, 'companyProfile' => $companyProfile));
            Storage::put('public/results_pdf/'.$resultsDtl[0]->pdf, $pdf->output());
            //$pdffile = preg_replace('/[^A-Za-z0-9\-]/', '_', $resultsDtl[0]->name) . '.pdf';

            $pdf->setPaper($customPaper);
            return $pdf->stream();

            /*return view('diagnostics.forms.PDFResults')
                ->with('pdffile', $pdffile);*/
        } else {
            return view('pos.resultsPrintPreviewUnavailable');
        }

    }

    public function ECGResultsPreview($preview_id)
    {
        if (Auth::check()) {
            $store_id = auth()->user()->store_id;
            $user_class = auth()->user()->class;
        } else {
            $store_id = "1";
        }

        // save as PDF

        /*$orderDetails = Laboratory_test_result::with('referenceValue')->where('or_no', $rid)->where('sub_classification_id', $sub_classification_id)->get();*/

        $resultsDtl = DB::table('diagnostic_view')


            ->leftjoin('signatories as a', 'diagnostic_view.performed_by', 'a.access_id')
            ->leftjoin('signatories as b', 'diagnostic_view.approved_by', 'b.access_id')
            ->select('diagnostic_view.avatar', 'diagnostic_view.name', 'diagnostic_view.suffix', 'diagnostic_view.gender', 'diagnostic_view.age', 'diagnostic_view.birthday', 'diagnostic_view.civil_status',  'diagnostic_view.telno', 'diagnostic_view.mobile_no', 'diagnostic_view.email', 'diagnostic_view.ID_presented', 'diagnostic_view.ID_no', 'diagnostic_view.address', 'diagnostic_view.referring_institution', 'diagnostic_view.pdf', 'diagnostic_view.preview_id',  'diagnostic_view.results as results',  'diagnostic_view.remarks',  'diagnostic_view.others','diagnostic_view.med_cert_date_issued', 'diagnostic_view.Height', 'diagnostic_view.Weight', 'diagnostic_view.BPSystolic', 'diagnostic_view.BPDiastolic', 'a.signatory as performed_by','b.signatory as approved_by','a.title as title','b.title as title2', 'a.designation as designation1', 'b.designation as designation2', 'a.ID_description as ID1', 'b.ID_description as ID2', 'a.ID_no as ID_no1', 'b.ID_no as ID_no2','a.expiry_date as ID_expiry1', 'b.expiry_date as ID_expiry2', 'a.signature as signature1', 'b.signature as signature2')
            ->where('diagnostic_view.store_id', $store_id)
            ->where('diagnostic_view.preview_id', $preview_id)
            ->first();

        if ($resultsDtl) {
            $companyProfile = DB::table('profiles')
                ->where('profiles.id', $store_id )->get();

//      Signature
            if(!empty($resultsDtl->signature1)){
                $signature1 = 'storage/signatory_image/'.$resultsDtl->signature1;
                if(@file_get_contents($signature1)){
                    $signature1_data = file_get_contents($signature1);
                    $extension = pathinfo($signature1, PATHINFO_EXTENSION);
                    $signature1_base_64 = base64_encode($signature1_data);
                    $signature1_img = 'data:image/' . $extension . ';base64,' . $signature1_base_64;
                    $resultsDtl->signature1 = $signature1_img;
                }
            }

            if(!empty($resultsDtl->signature2)){
                $signature2 = 'storage/signatory_image/'.$resultsDtl->signature2;
                if(@file_get_contents($signature2)){
                    $signature2_data = file_get_contents($signature2);
                    $extension = pathinfo($signature2, PATHINFO_EXTENSION);
                    $signature2_base_64 = base64_encode($signature2_data);
                    $signature2_img = 'data:image/' . $extension . ';base64,' . $signature2_base_64;
                    $resultsDtl->signature2 = $signature2_img;
                }
            }

            $customPaper = array(0, 0, 612.00, (792.00));
            $pdf = PDF::loadView('diagnostics.forms.ECGResults', array('resultsDtl' => $resultsDtl, 'companyProfile' => $companyProfile));
            Storage::put('public/results_pdf/'.$resultsDtl->pdf, $pdf->output());
            //$pdffile = preg_replace('/[^A-Za-z0-9\-]/', '_', $resultsDtl[0]->name) . '.pdf';

            $pdf->setPaper($customPaper);
            return $pdf->stream();

            /*return view('diagnostics.forms.PDFResults')
                ->with('pdffile', $pdffile);*/
        } else {
            return view('pos.resultsPrintPreviewUnavailable');
        }

    }

    public function PsychoResultsPreview($preview_id)
    {
        if (Auth::check()) {
            $store_id = auth()->user()->store_id;
            $user_class = auth()->user()->class;
        } else {
            $store_id = "1";
        }

        $resultsDtl = DB::table('diagnostic_view')


            ->join('psycho_test_results', 'psycho_test_results.or_no', 'diagnostic_view.or_no')
            ->leftjoin('signatories as a', 'diagnostic_view.performed_by', 'a.access_id')
            ->leftjoin('signatories as b', 'diagnostic_view.approved_by', 'b.access_id')
            ->select('psycho_test_results.*', 'diagnostic_view.avatar', 'diagnostic_view.name', 'diagnostic_view.suffix', 'diagnostic_view.gender', 'diagnostic_view.age', 'diagnostic_view.birthday', 'diagnostic_view.civil_status', 'diagnostic_view.position_applied', 'diagnostic_view.gender', 'diagnostic_view.telno', 'diagnostic_view.mobile_no', 'diagnostic_view.mobile_no', 'diagnostic_view.email', 'diagnostic_view.ID_presented', 'diagnostic_view.ID_no', 'diagnostic_view.address', 'diagnostic_view.referring_institution', 'diagnostic_view.profession_occupation', 'diagnostic_view.pdf', 'diagnostic_view.preview_id',  'diagnostic_view.results as results',  'diagnostic_view.remarks',  'diagnostic_view.med_cert_date_issued', 'diagnostic_view.Height', 'diagnostic_view.Weight', 'diagnostic_view.BPSystolic', 'diagnostic_view.BPDiastolic', 'a.signatory as performed_by','b.signatory as approved_by','a.title as title','b.title as title2', 'a.designation as designation1', 'b.designation as designation2', 'a.ID_description as ID1', 'b.ID_description as ID2', 'a.ID_no as ID_no1', 'b.ID_no as ID_no2','a.expiry_date as ID_expiry1', 'b.expiry_date as ID_expiry2', 'a.signature as signature1', 'b.signature as signature2')
            ->where('diagnostic_view.store_id', $store_id)
            ->where('diagnostic_view.preview_id', $preview_id)
            ->first();


        if ($resultsDtl) {

//      Signature
            if(!empty($resultsDtl->signature1)){
                $signature1 = 'storage/signatory_image/'.$resultsDtl->signature1;
                if(@file_get_contents($signature1)){
                    $signature1_data = file_get_contents($signature1);
                    $extension = pathinfo($signature1, PATHINFO_EXTENSION);
                    $signature1_base_64 = base64_encode($signature1_data);
                    $signature1_img = 'data:image/' . $extension . ';base64,' . $signature1_base_64;
                    $resultsDtl->signature1 = $signature1_img;
                }
            }

            if(!empty($resultsDtl->signature2)){
                $signature2 = 'storage/signatory_image/'.$resultsDtl->signature2;
                if(@file_get_contents($signature2)){
                    $signature2_data = file_get_contents($signature2);
                    $extension = pathinfo($signature2, PATHINFO_EXTENSION);
                    $signature2_base_64 = base64_encode($signature2_data);
                    $signature2_img = 'data:image/' . $extension . ';base64,' . $signature2_base_64;
                    $resultsDtl->signature2 = $signature2_img;
                }
            }

            $customPaper = array(0, 0, 612.00, (792.00));
            $pdf = PDF::loadView('diagnostics.forms.PsychoResults', array('resultsDtl' => $resultsDtl));
            Storage::put('public/results_pdf/'.$resultsDtl->pdf, $pdf->output());
            $pdffile = preg_replace('/[^A-Za-z0-9\-]/', '_', $resultsDtl->name) . '.pdf';

            /*$pdf->setPaper($customPaper);
            return $pdf->stream();*/

            return view('diagnostics.forms.PDFResults')
                ->with('resultsDtl', $resultsDtl)
                ->with('pdffile', $pdffile);
        } else {
            return view('pos.resultsPrintPreviewUnavailable');
        }

    }

    public function printBasic5($id, $preview_id){

        if (Auth::check()) {
            // user is logged in
            $store_id = auth()->user()->store_id;
        } else {
            return redirect()->guest(route('login'));
        }

        $CBC = Laboratory_test_result::with('referenceValue')->where('or_no', $id)->where('sub_classification_id', '19')->get();
        $FECALYSIS = Laboratory_test_result::with('referenceValue')->where('or_no', $id)->where('sub_classification_id', '53')->get();
        $URINALYSIS = Laboratory_test_result::with('referenceValue')->where('or_no', $id)->where('sub_classification_id', '126')->get();
        $ABOTHTYPING = Laboratory_test_result::with('referenceValue')->where('or_no', $id)->where('sub_classification_id', '4')->get();
        $PREGNANCY = Laboratory_test_result::with('referenceValue')->where('or_no', $id)->where('sub_classification_id', '125')->get();
        $TPHA = Laboratory_test_result::with('referenceValue')->where('or_no', $id)->where('sub_classification_id', '104')->get();
        $HBsAg = Laboratory_test_result::with('referenceValue')->where('or_no', $id)->where('sub_classification_id', '63')->get();
        $HIV = Laboratory_test_result::with('referenceValue')->where('or_no', $id)->where('sub_classification_id', '99')->get();
        $MALARIALSMEAR = Laboratory_test_result::with('referenceValue')->where('or_no', $id)->where('sub_classification_id', '142')->get();
        $ANTIHAVIGG = Laboratory_test_result::with('referenceValue')->where('or_no', $id)->where('sub_classification_id', '74')->get();
        $AntiHCV = Laboratory_test_result::with('referenceValue')->where('or_no', $id)->where('sub_classification_id', '98')->get();
        $FastingBloodSugar = Laboratory_test_result::with('referenceValue')->where('or_no', $id)->where('sub_classification_id', '52')->get();
        $HBA1C = Laboratory_test_result::with('referenceValue')->where('or_no', $id)->where('sub_classification_id', '59')->get();
        $Creatinine = Laboratory_test_result::with('referenceValue')->where('or_no', $id)->where('sub_classification_id', '34')->get();

        /*CBC = 19
        Fecalysis = 53
        URINALYSIS = 126
        ABOTHTYPING = 4
        PREGNANCY = 125
        TPHA = 104 (RT-S-Syphilis Test)
        HBsAg = 68
        HIV = 99
        MALARIALSMEAR = 142
        ANTIHAVIGG = 74
        AntiHCV = 98
        FastingBloodSugar = 52
        HBA1C = 59
        Creatinine = 34*/

        $resultsDtl = DB::table('diagnostic_view')


            ->leftjoin('signatories as a', 'diagnostic_view.performed_by', 'a.access_id')
            ->leftjoin('signatories as b', 'diagnostic_view.approved_by', 'b.access_id')
            ->select('diagnostic_view.avatar', 'diagnostic_view.name', 'diagnostic_view.suffix', 'diagnostic_view.gender', 'diagnostic_view.age', 'diagnostic_view.birthday', 'diagnostic_view.civil_status',  'diagnostic_view.telno', 'diagnostic_view.mobile_no', 'diagnostic_view.email', 'diagnostic_view.ID_presented', 'diagnostic_view.ID_no', 'diagnostic_view.address', 'diagnostic_view.referring_institution', 'diagnostic_view.pdf', 'diagnostic_view.preview_id', 'diagnostic_view.remarks',  'diagnostic_view.others','diagnostic_view.med_cert_date_issued', 'a.signatory as performed_by','b.signatory as approved_by','a.title as title','b.title as title2', 'a.designation as designation1', 'b.designation as designation2', 'a.ID_description as ID1', 'b.ID_description as ID2', 'a.ID_no as ID_no1', 'b.ID_no as ID_no2','a.expiry_date as ID_expiry1', 'b.expiry_date as ID_expiry2', 'a.signature as signature1', 'b.signature as signature2')
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

            if (!empty($resultsDtl->signature2)) {
                $signature2 = 'storage/signatory_image/' . $resultsDtl->signature2;
                if (@file_get_contents($signature2)) {
                    $signature2_data = file_get_contents($signature2);
                    $extension = pathinfo($signature2, PATHINFO_EXTENSION);
                    $signature2_base_64 = base64_encode($signature2_data);
                    $signature2_img = 'data:image/' . $extension . ';base64,' . $signature2_base_64;
                    $resultsDtl->signature2 = $signature2_img;
                }
            }

        }

        $customPaper = array(0, 0, 600.00, (832.00));
        /*$customPaper = array(0, 0, 612.00, (792.00));*/
        $pdf = PDF::loadView('diagnostics.forms.basicFiveResults',
            array('resultsDtl' => $resultsDtl,
                'CBC' => $CBC,
                'FECALYSIS' => $FECALYSIS,
                'URINALYSIS' => $URINALYSIS,
                'ABOTHTYPING' => $ABOTHTYPING,
                'PREGNANCY' => $PREGNANCY,
                'TPHA' => $TPHA,
                'HBsAg' => $HBsAg,
                'HIV' => $HIV,
                'MALARIALSMEAR' => $MALARIALSMEAR,
                'ANTIHAVIGG' => $ANTIHAVIGG,
                'AntiHCV' => $AntiHCV,
                'FastingBloodSugar' => $FastingBloodSugar,
                'HBA1C' => $HBA1C,
                'Creatinine' => $Creatinine));
        $pdf->setPaper($customPaper);
        return $pdf->stream();
    }

    public function printSingapore($id, $preview_id){
        if (Auth::check()) {
            // user is logged in
            $store_id = auth()->user()->store_id;
        } else {
            return redirect()->guest(route('login'));
        }

        $CBC = Laboratory_test_result::with('referenceValue')->where('or_no', $id)->where('sub_classification_id', '19')->get();
        $FECALYSIS = Laboratory_test_result::with('referenceValue')->where('or_no', $id)->where('sub_classification_id', '53')->get();
        $URINALYSIS = Laboratory_test_result::with('referenceValue')->where('or_no', $id)->where('sub_classification_id', '126')->get();
        $ABOTHTYPING = Laboratory_test_result::with('referenceValue')->where('or_no', $id)->where('sub_classification_id', '4')->get();
        $PREGNANCY = Laboratory_test_result::with('referenceValue')->where('or_no', $id)->where('sub_classification_id', '125')->get();
        $TPHA = Laboratory_test_result::with('referenceValue')->where('or_no', $id)->where('sub_classification_id', '104')->get();
        $HBsAg = Laboratory_test_result::with('referenceValue')->where('or_no', $id)->where('sub_classification_id', '63')->get();
        $HIV = Laboratory_test_result::with('referenceValue')->where('or_no', $id)->where('sub_classification_id', '99')->get();
        $MALARIALSMEAR = Laboratory_test_result::with('referenceValue')->where('or_no', $id)->where('sub_classification_id', '142')->get();
        $ANTIHAVIGG = Laboratory_test_result::with('referenceValue')->where('or_no', $id)->where('sub_classification_id', '74')->get();
        $AntiHCV = Laboratory_test_result::with('referenceValue')->where('or_no', $id)->where('sub_classification_id', '98')->get();
        $FastingBloodSugar = Laboratory_test_result::with('referenceValue')->where('or_no', $id)->where('sub_classification_id', '52')->get();
        $HBA1C = Laboratory_test_result::with('referenceValue')->where('or_no', $id)->where('sub_classification_id', '59')->get();
        $Creatinine = Laboratory_test_result::with('referenceValue')->where('or_no', $id)->where('sub_classification_id', '34')->get();

        $resultsDtl = DB::table('diagnostic_view')


            ->leftjoin('signatories as a', 'diagnostic_view.performed_by', 'a.access_id')
            ->leftjoin('signatories as b', 'diagnostic_view.approved_by', 'b.access_id')
            ->select('diagnostic_view.avatar', 'diagnostic_view.name', 'diagnostic_view.suffix', 'diagnostic_view.gender', 'diagnostic_view.age', 'diagnostic_view.birthday', 'diagnostic_view.civil_status',  'diagnostic_view.telno', 'diagnostic_view.mobile_no', 'diagnostic_view.email', 'diagnostic_view.ID_presented', 'diagnostic_view.ID_no', 'diagnostic_view.address', 'diagnostic_view.referring_institution', 'diagnostic_view.pdf', 'diagnostic_view.preview_id', 'diagnostic_view.remarks',  'diagnostic_view.others','diagnostic_view.med_cert_date_issued', 'a.signatory as performed_by','b.signatory as approved_by','a.title as title','b.title as title2', 'a.designation as designation1', 'b.designation as designation2', 'a.ID_description as ID1', 'b.ID_description as ID2', 'a.ID_no as ID_no1', 'b.ID_no as ID_no2','a.expiry_date as ID_expiry1', 'b.expiry_date as ID_expiry2', 'a.signature as signature1', 'b.signature as signature2')
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

            if (!empty($resultsDtl->signature2)) {
                $signature2 = 'storage/signatory_image/' . $resultsDtl->signature2;
                if (@file_get_contents($signature2)) {
                    $signature2_data = file_get_contents($signature2);
                    $extension = pathinfo($signature2, PATHINFO_EXTENSION);
                    $signature2_base_64 = base64_encode($signature2_data);
                    $signature2_img = 'data:image/' . $extension . ';base64,' . $signature2_base_64;
                    $resultsDtl->signature2 = $signature2_img;
                }
            }

        }

        $customPaper = array(0, 0, 600.00, (832.00));
        //$customPaper = array(0, 0, 612.00, (792.00));

        $pdf = PDF::loadView('diagnostics.forms.singaporeResults',
            array('resultsDtl' => $resultsDtl,
                'CBC' => $CBC,
                'FECALYSIS' => $FECALYSIS,
                'URINALYSIS' => $URINALYSIS,
                'ABOTHTYPING' => $ABOTHTYPING,
                'PREGNANCY' => $PREGNANCY,
                'TPHA' => $TPHA,
                'HBsAg' => $HBsAg,
                'HIV' => $HIV,
                'MALARIALSMEAR' => $MALARIALSMEAR,
                'ANTIHAVIGG' => $ANTIHAVIGG,
                'AntiHCV' => $AntiHCV,
                'FastingBloodSugar' => $FastingBloodSugar,
                'HBA1C' => $HBA1C,
                'Creatinine' => $Creatinine));

        $pdf->setPaper($customPaper);
        return $pdf->stream();
    }

    public function printInterworld($id, $preview_id){
        if (Auth::check()) {
            // user is logged in
            $store_id = auth()->user()->store_id;
        } else {
            return redirect()->guest(route('login'));
        }

        $CBC = Laboratory_test_result::with('referenceValue')->where('or_no', $id)->where('sub_classification_id', '19')->get();
        $FECALYSIS = Laboratory_test_result::with('referenceValue')->where('or_no', $id)->where('sub_classification_id', '53')->get();
        $URINALYSIS = Laboratory_test_result::with('referenceValue')->where('or_no', $id)->where('sub_classification_id', '126')->get();
        $ABOTHTYPING = Laboratory_test_result::with('referenceValue')->where('or_no', $id)->where('sub_classification_id', '4')->get();
        $PREGNANCY = Laboratory_test_result::with('referenceValue')->where('or_no', $id)->where('sub_classification_id', '125')->get();
        $TPHA = Laboratory_test_result::with('referenceValue')->where('or_no', $id)->where('sub_classification_id', '104')->get();
        $HBsAg = Laboratory_test_result::with('referenceValue')->where('or_no', $id)->where('sub_classification_id', '63')->get();
        $HIV = Laboratory_test_result::with('referenceValue')->where('or_no', $id)->where('sub_classification_id', '99')->get();
        $MALARIALSMEAR = Laboratory_test_result::with('referenceValue')->where('or_no', $id)->where('sub_classification_id', '142')->get();
        $ANTIHAVIGG = Laboratory_test_result::with('referenceValue')->where('or_no', $id)->where('sub_classification_id', '74')->get();
        $AntiHCV = Laboratory_test_result::with('referenceValue')->where('or_no', $id)->where('sub_classification_id', '98')->get();
        $FastingBloodSugar = Laboratory_test_result::with('referenceValue')->where('or_no', $id)->where('sub_classification_id', '52')->get();
        $HBA1C = Laboratory_test_result::with('referenceValue')->where('or_no', $id)->where('sub_classification_id', '59')->get();
        $Creatinine = Laboratory_test_result::with('referenceValue')->where('or_no', $id)->where('sub_classification_id', '34')->get();

        $resultsDtl = DB::table('diagnostic_view')


            ->leftjoin('signatories as a', 'diagnostic_view.performed_by', 'a.access_id')
            ->leftjoin('signatories as b', 'diagnostic_view.approved_by', 'b.access_id')
            ->select('diagnostic_view.avatar', 'diagnostic_view.name', 'diagnostic_view.suffix', 'diagnostic_view.gender', 'diagnostic_view.age', 'diagnostic_view.birthday', 'diagnostic_view.civil_status',  'diagnostic_view.telno', 'diagnostic_view.mobile_no', 'diagnostic_view.email', 'diagnostic_view.ID_presented', 'diagnostic_view.ID_no', 'diagnostic_view.address', 'diagnostic_view.referring_institution', 'diagnostic_view.pdf', 'diagnostic_view.preview_id', 'diagnostic_view.remarks',  'diagnostic_view.others','diagnostic_view.med_cert_date_issued', 'a.signatory as performed_by','b.signatory as approved_by','a.title as title','b.title as title2', 'a.designation as designation1', 'b.designation as designation2', 'a.ID_description as ID1', 'b.ID_description as ID2', 'a.ID_no as ID_no1', 'b.ID_no as ID_no2','a.expiry_date as ID_expiry1', 'b.expiry_date as ID_expiry2', 'a.signature as signature1', 'b.signature as signature2')
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

            if (!empty($resultsDtl->signature2)) {
                $signature2 = 'storage/signatory_image/' . $resultsDtl->signature2;
                if (@file_get_contents($signature2)) {
                    $signature2_data = file_get_contents($signature2);
                    $extension = pathinfo($signature2, PATHINFO_EXTENSION);
                    $signature2_base_64 = base64_encode($signature2_data);
                    $signature2_img = 'data:image/' . $extension . ';base64,' . $signature2_base_64;
                    $resultsDtl->signature2 = $signature2_img;
                }
            }

        }

        //$customPaper = array(0, 0, 612.00, (792.00));
        $customPaper = array(0, 0, 600.00, (832.00));

        $pdf = PDF::loadView('diagnostics.forms.interworldResults',
            array('resultsDtl' => $resultsDtl,
                'CBC' => $CBC,
                'FECALYSIS' => $FECALYSIS,
                'URINALYSIS' => $URINALYSIS,
                'ABOTHTYPING' => $ABOTHTYPING,
                'PREGNANCY' => $PREGNANCY,
                'TPHA' => $TPHA,
                'HBsAg' => $HBsAg,
                'HIV' => $HIV,
                'MALARIALSMEAR' => $MALARIALSMEAR,
                'ANTIHAVIGG' => $ANTIHAVIGG,
                'AntiHCV' => $AntiHCV,
                'FastingBloodSugar' => $FastingBloodSugar,
                'HBA1C' => $HBA1C,
                'Creatinine' => $Creatinine));
        $pdf->setPaper($customPaper);
        return $pdf->stream();
    }

    public function printTechnoPackA($id, $preview_id){
        if (Auth::check()) {
            // user is logged in
            $store_id = auth()->user()->store_id;
        } else {
            return redirect()->guest(route('login'));
        }

        $CBC = Laboratory_test_result::with('referenceValue')->where('or_no', $id)->where('sub_classification_id', '19')->get();
        $FECALYSIS = Laboratory_test_result::with('referenceValue')->where('or_no', $id)->where('sub_classification_id', '53')->get();
        $URINALYSIS = Laboratory_test_result::with('referenceValue')->where('or_no', $id)->where('sub_classification_id', '126')->get();
        $ABOTHTYPING = Laboratory_test_result::with('referenceValue')->where('or_no', $id)->where('sub_classification_id', '4')->get();
        $PREGNANCY = Laboratory_test_result::with('referenceValue')->where('or_no', $id)->where('sub_classification_id', '125')->get();
        $TPHA = Laboratory_test_result::with('referenceValue')->where('or_no', $id)->where('sub_classification_id', '104')->get();
        $HBsAg = Laboratory_test_result::with('referenceValue')->where('or_no', $id)->where('sub_classification_id', '63')->get();
        $HIV = Laboratory_test_result::with('referenceValue')->where('or_no', $id)->where('sub_classification_id', '99')->get();
        $MALARIALSMEAR = Laboratory_test_result::with('referenceValue')->where('or_no', $id)->where('sub_classification_id', '142')->get();
        $ANTIHAVIGG = Laboratory_test_result::with('referenceValue')->where('or_no', $id)->where('sub_classification_id', '74')->get();
        $AntiHCV = Laboratory_test_result::with('referenceValue')->where('or_no', $id)->where('sub_classification_id', '98')->get();
        $FastingBloodSugar = Laboratory_test_result::with('referenceValue')->where('or_no', $id)->where('sub_classification_id', '52')->get();
        $HBA1C = Laboratory_test_result::with('referenceValue')->where('or_no', $id)->where('sub_classification_id', '59')->get();
        $Creatinine = Laboratory_test_result::with('referenceValue')->where('or_no', $id)->where('sub_classification_id', '34')->get();

        $resultsDtl = DB::table('diagnostic_view')


            ->leftjoin('signatories as a', 'diagnostic_view.performed_by', 'a.access_id')
            ->leftjoin('signatories as b', 'diagnostic_view.approved_by', 'b.access_id')
            ->select('diagnostic_view.avatar', 'diagnostic_view.name', 'diagnostic_view.suffix', 'diagnostic_view.gender', 'diagnostic_view.age', 'diagnostic_view.birthday', 'diagnostic_view.civil_status',  'diagnostic_view.telno', 'diagnostic_view.mobile_no', 'diagnostic_view.email', 'diagnostic_view.ID_presented', 'diagnostic_view.ID_no', 'diagnostic_view.address', 'diagnostic_view.referring_institution', 'diagnostic_view.pdf', 'diagnostic_view.preview_id', 'diagnostic_view.remarks',  'diagnostic_view.others','diagnostic_view.med_cert_date_issued', 'a.signatory as performed_by','b.signatory as approved_by','a.title as title','b.title as title2', 'a.designation as designation1', 'b.designation as designation2', 'a.ID_description as ID1', 'b.ID_description as ID2', 'a.ID_no as ID_no1', 'b.ID_no as ID_no2','a.expiry_date as ID_expiry1', 'b.expiry_date as ID_expiry2', 'a.signature as signature1', 'b.signature as signature2')
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

            if (!empty($resultsDtl->signature2)) {
                $signature2 = 'storage/signatory_image/' . $resultsDtl->signature2;
                if (@file_get_contents($signature2)) {
                    $signature2_data = file_get_contents($signature2);
                    $extension = pathinfo($signature2, PATHINFO_EXTENSION);
                    $signature2_base_64 = base64_encode($signature2_data);
                    $signature2_img = 'data:image/' . $extension . ';base64,' . $signature2_base_64;
                    $resultsDtl->signature2 = $signature2_img;
                }
            }

        }

        //$customPaper = array(0, 0, 612.00, (792.00));
        $customPaper = array(0, 0, 600.00, (832.00));

        $pdf = PDF::loadView('diagnostics.forms.technopackAResults',
            array('resultsDtl' => $resultsDtl,
                'CBC' => $CBC,
                'FECALYSIS' => $FECALYSIS,
                'URINALYSIS' => $URINALYSIS,
                'ABOTHTYPING' => $ABOTHTYPING,
                'PREGNANCY' => $PREGNANCY,
                'TPHA' => $TPHA,
                'HBsAg' => $HBsAg,
                'HIV' => $HIV,
                'MALARIALSMEAR' => $MALARIALSMEAR,
                'ANTIHAVIGG' => $ANTIHAVIGG,
                'AntiHCV' => $AntiHCV,
                'FastingBloodSugar' => $FastingBloodSugar,
                'HBA1C' => $HBA1C,
                'Creatinine' => $Creatinine));
        $pdf->setPaper($customPaper);
        return $pdf->stream();
    }

    public function printTechnoPackB($id, $preview_id){
        if (Auth::check()) {
            // user is logged in
            $store_id = auth()->user()->store_id;
        } else {
            return redirect()->guest(route('login'));
        }

        $CBC = Laboratory_test_result::with('referenceValue')->where('or_no', $id)->where('sub_classification_id', '19')->get();
        $FECALYSIS = Laboratory_test_result::with('referenceValue')->where('or_no', $id)->where('sub_classification_id', '53')->get();
        $URINALYSIS = Laboratory_test_result::with('referenceValue')->where('or_no', $id)->where('sub_classification_id', '126')->get();
        $ABOTHTYPING = Laboratory_test_result::with('referenceValue')->where('or_no', $id)->where('sub_classification_id', '4')->get();
        $PREGNANCY = Laboratory_test_result::with('referenceValue')->where('or_no', $id)->where('sub_classification_id', '125')->get();
        $TPHA = Laboratory_test_result::with('referenceValue')->where('or_no', $id)->where('sub_classification_id', '104')->get();
        $HBsAg = Laboratory_test_result::with('referenceValue')->where('or_no', $id)->where('sub_classification_id', '63')->get();
        $HIV = Laboratory_test_result::with('referenceValue')->where('or_no', $id)->where('sub_classification_id', '99')->get();
        $MALARIALSMEAR = Laboratory_test_result::with('referenceValue')->where('or_no', $id)->where('sub_classification_id', '142')->get();
        $ANTIHAVIGG = Laboratory_test_result::with('referenceValue')->where('or_no', $id)->where('sub_classification_id', '74')->get();
        $AntiHCV = Laboratory_test_result::with('referenceValue')->where('or_no', $id)->where('sub_classification_id', '98')->get();
        $FastingBloodSugar = Laboratory_test_result::with('referenceValue')->where('or_no', $id)->where('sub_classification_id', '52')->get();
        $HBA1C = Laboratory_test_result::with('referenceValue')->where('or_no', $id)->where('sub_classification_id', '59')->get();
        $Creatinine = Laboratory_test_result::with('referenceValue')->where('or_no', $id)->where('sub_classification_id', '34')->get();

        $resultsDtl = DB::table('diagnostic_view')


            ->leftjoin('signatories as a', 'diagnostic_view.performed_by', 'a.access_id')
            ->leftjoin('signatories as b', 'diagnostic_view.approved_by', 'b.access_id')
            ->select('diagnostic_view.avatar', 'diagnostic_view.name', 'diagnostic_view.suffix', 'diagnostic_view.gender', 'diagnostic_view.age', 'diagnostic_view.birthday', 'diagnostic_view.civil_status',  'diagnostic_view.telno', 'diagnostic_view.mobile_no', 'diagnostic_view.email', 'diagnostic_view.ID_presented', 'diagnostic_view.ID_no', 'diagnostic_view.address', 'diagnostic_view.referring_institution', 'diagnostic_view.pdf', 'diagnostic_view.preview_id', 'diagnostic_view.remarks',  'diagnostic_view.others','diagnostic_view.med_cert_date_issued', 'a.signatory as performed_by','b.signatory as approved_by','a.title as title','b.title as title2', 'a.designation as designation1', 'b.designation as designation2', 'a.ID_description as ID1', 'b.ID_description as ID2', 'a.ID_no as ID_no1', 'b.ID_no as ID_no2','a.expiry_date as ID_expiry1', 'b.expiry_date as ID_expiry2', 'a.signature as signature1', 'b.signature as signature2')
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

            if (!empty($resultsDtl->signature2)) {
                $signature2 = 'storage/signatory_image/' . $resultsDtl->signature2;
                if (@file_get_contents($signature2)) {
                    $signature2_data = file_get_contents($signature2);
                    $extension = pathinfo($signature2, PATHINFO_EXTENSION);
                    $signature2_base_64 = base64_encode($signature2_data);
                    $signature2_img = 'data:image/' . $extension . ';base64,' . $signature2_base_64;
                    $resultsDtl->signature2 = $signature2_img;
                }
            }

        }


        //$customPaper = array(0, 0, 612.00, (792.00));
        $customPaper = array(0, 0, 600.00, (832.00));
        $pdf = PDF::loadView('diagnostics.forms.technopackBResults',
            array('resultsDtl' => $resultsDtl,
                'CBC' => $CBC,
                'FECALYSIS' => $FECALYSIS,
                'URINALYSIS' => $URINALYSIS,
                'ABOTHTYPING' => $ABOTHTYPING,
                'PREGNANCY' => $PREGNANCY,
                'TPHA' => $TPHA,
                'HBsAg' => $HBsAg,
                'HIV' => $HIV,
                'MALARIALSMEAR' => $MALARIALSMEAR,
                'ANTIHAVIGG' => $ANTIHAVIGG,
                'AntiHCV' => $AntiHCV,
                'FastingBloodSugar' => $FastingBloodSugar,
                'HBA1C' => $HBA1C,
                'Creatinine' => $Creatinine));
        $pdf->setPaper($customPaper);
        return $pdf->stream();
    }

    public function printMedCertLandbased($id, $preview_id){

        if (Auth::check()) {
            // user is logged in
            $store_id = auth()->user()->store_id;
        } else {
            return redirect()->guest(route('login'));
        }

        $resultsDtl = DB::table('diagnostic_view')


            ->leftjoin('signatories as a', 'diagnostic_view.physician', 'a.access_id')
            ->leftjoin('signatories as b', 'diagnostic_view.director', 'b.access_id')
            ->select('diagnostic_view.avatar', 'diagnostic_view.name', 'diagnostic_view.first_name', 'diagnostic_view.last_name', 'diagnostic_view.middle_name', 'diagnostic_view.suffix', 'diagnostic_view.gender', 'diagnostic_view.age', 'diagnostic_view.birthday', 'diagnostic_view.civil_status', 'diagnostic_view.position_applied', 'diagnostic_view.nationality', 'diagnostic_view.religion', 'diagnostic_view.country', 'diagnostic_view.place_of_birth', 'diagnostic_view.telno', 'diagnostic_view.mobile_no', 'diagnostic_view.email', 'diagnostic_view.application_type', 'diagnostic_view.position_on_board', 'diagnostic_view.passport_no', 'diagnostic_view.sirb', 'diagnostic_view.ID_presented', 'diagnostic_view.ID_no', 'diagnostic_view.address', 'diagnostic_view.referring_institution', 'diagnostic_view.pdf', 'diagnostic_view.preview_id', 'diagnostic_view.remarks', 'diagnostic_view.others', 'diagnostic_view.Spectacles', 'diagnostic_view.ContactLenses', 'diagnostic_view.LastColorVisionTest', 'diagnostic_view.med_cert_date_issued', 'diagnostic_view.med_exam_date','diagnostic_view.med_exam_expiry_date','diagnostic_view.med_cert_date_issued','diagnostic_view.med_exam_report_no', 'diagnostic_view.FitForLookOutDuty', 'diagnostic_view.WithRestrictions', 'diagnostic_view.Restrictions','diagnostic_view.PsychologicalTest',  'diagnostic_view.SatisfactoryHearing', 'diagnostic_view.SatisfactoryUnaidedHearing', 'diagnostic_view.SatisfactorySight', 'diagnostic_view.SatisfactoryColorVision', 'diagnostic_view.SufferingFromMedicalCondition', 'a.signatory as physician','b.signatory as director','a.title as title','b.title as title2', 'a.designation as designation1', 'b.designation as designation2', 'a.ID_description as ID1', 'b.ID_description as ID2', 'a.ID_no as ID_no1', 'b.ID_no as ID_no2','a.expiry_date as ID_expiry1', 'b.expiry_date as ID_expiry2', 'a.signature as signature1', 'b.signature as signature2')
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

            if (!empty($resultsDtl->signature2)) {
                $signature2 = 'storage/signatory_image/' . $resultsDtl->signature2;
                if (@file_get_contents($signature2)) {
                    $signature2_data = file_get_contents($signature2);
                    $extension = pathinfo($signature2, PATHINFO_EXTENSION);
                    $signature2_base_64 = base64_encode($signature2_data);
                    $signature2_img = 'data:image/' . $extension . ';base64,' . $signature2_base_64;
                    $resultsDtl->signature2 = $signature2_img;
                }
            }

//      Avatar
            if (!empty($resultsDtl->avatar)) {
                $avatar = 'storage/customer_image/' . $resultsDtl->avatar;
                if (@file_get_contents($avatar)) {
                    $avatar_data = file_get_contents($avatar);
                    $extencion = pathinfo($avatar, PATHINFO_EXTENSION);
                    $avatar_base_64 = base64_encode($avatar_data);
                    $avatar_img = 'data:image/' . $extencion . ';base64,' . $avatar_base_64;
                    $resultsDtl->avatar = $avatar_img;
                }
            }

        }

        $customPaper = array(0, 0, 600.00, (832.00));
        $pdf = PDF::loadView('diagnostics.forms.medicalCertificateForLandbasedOverseasWorkers',
            array('resultsDtl' => $resultsDtl,
                'preview_id' => $preview_id));

        $pdf->setPaper($customPaper);
        return $pdf->stream();
    }

    public function printMedCertSeabased($id, $preview_id){

        if (Auth::check()) {
            // user is logged in
            $store_id = auth()->user()->store_id;
        } else {
            return redirect()->guest(route('login'));
        }

        $resultsDtl = DB::table('diagnostic_view')


            ->leftjoin('signatories as a', 'diagnostic_view.physician', 'a.access_id')
            ->leftjoin('signatories as b', 'diagnostic_view.director', 'b.access_id')
            ->select('diagnostic_view.avatar', 'diagnostic_view.name', 'diagnostic_view.first_name', 'diagnostic_view.last_name', 'diagnostic_view.middle_name', 'diagnostic_view.suffix', 'diagnostic_view.gender', 'diagnostic_view.age', 'diagnostic_view.birthday', 'diagnostic_view.civil_status', 'diagnostic_view.position_applied', 'diagnostic_view.nationality', 'diagnostic_view.religion', 'diagnostic_view.country', 'diagnostic_view.place_of_birth', 'diagnostic_view.telno', 'diagnostic_view.mobile_no', 'diagnostic_view.email', 'diagnostic_view.application_type', 'diagnostic_view.position_on_board', 'diagnostic_view.passport_no', 'diagnostic_view.sirb', 'diagnostic_view.ID_presented', 'diagnostic_view.ID_no', 'diagnostic_view.address', 'diagnostic_view.referring_institution', 'diagnostic_view.pdf', 'diagnostic_view.preview_id', 'diagnostic_view.remarks', 'diagnostic_view.others', 'diagnostic_view.Spectacles', 'diagnostic_view.ContactLenses', 'diagnostic_view.LastColorVisionTest', 'diagnostic_view.med_cert_date_issued', 'diagnostic_view.med_exam_date','diagnostic_view.med_exam_expiry_date','diagnostic_view.med_cert_date_issued','diagnostic_view.med_exam_report_no', 'diagnostic_view.FitForLookOutDuty', 'diagnostic_view.WithRestrictions', 'diagnostic_view.Restrictions','diagnostic_view.PsychologicalTest',  'diagnostic_view.SatisfactoryHearing', 'diagnostic_view.SatisfactoryUnaidedHearing', 'diagnostic_view.SatisfactorySight', 'diagnostic_view.SatisfactoryColorVision', 'diagnostic_view.SufferingFromMedicalCondition', 'a.signatory as physician','b.signatory as director','a.title as title','b.title as title2', 'a.designation as designation1', 'b.designation as designation2', 'a.ID_description as ID1', 'b.ID_description as ID2', 'a.ID_no as ID_no1', 'b.ID_no as ID_no2','a.expiry_date as ID_expiry1', 'b.expiry_date as ID_expiry2', 'a.signature as signature1', 'b.signature as signature2')
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

            if (!empty($resultsDtl->signature2)) {
                $signature2 = 'storage/signatory_image/' . $resultsDtl->signature2;
                if (@file_get_contents($signature2)) {
                    $signature2_data = file_get_contents($signature2);
                    $extension = pathinfo($signature2, PATHINFO_EXTENSION);
                    $signature2_base_64 = base64_encode($signature2_data);
                    $signature2_img = 'data:image/' . $extension . ';base64,' . $signature2_base_64;
                    $resultsDtl->signature2 = $signature2_img;
                }
            }

//      Avatar
            if (!empty($resultsDtl->avatar)) {
                $avatar = 'storage/customer_image/' . $resultsDtl->avatar;
                if (@file_get_contents($avatar)) {
                    $avatar_data = file_get_contents($avatar);
                    $extencion = pathinfo($avatar, PATHINFO_EXTENSION);
                    $avatar_base_64 = base64_encode($avatar_data);
                    $avatar_img = 'data:image/' . $extencion . ';base64,' . $avatar_base_64;
                    $resultsDtl->avatar = $avatar_img;
                }
            }

        }

        $customPaper = array(0, 0, 600.00, (832.00));
        $pdf = PDF::loadView('diagnostics.forms.medicalCertificateForSeaWorkers',
            array('resultsDtl' => $resultsDtl,
                'preview_id' => $preview_id));

        $pdf->setPaper($customPaper);
        return $pdf->stream();
    }

    public function printMedExamLandbased($id, $preview_id){
        if (Auth::check()) {
            // user is logged in
            $store_id = auth()->user()->store_id;
        } else {
            return redirect()->guest(route('login'));
        }

        $resultsDtl = DB::table('diagnostic_view')


            ->leftjoin('signatories as a', 'diagnostic_view.physician', 'a.access_id')
            ->select('diagnostic_view.*', 'a.signatory as physician','a.title as title', 'a.designation as designation1', 'a.ID_description as ID1', 'a.ID_no as ID_no1', 'a.expiry_date as ID_expiry1', 'a.signature as signature1')
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

        $customPaper = array(0, 0, 600.00, (832.00));
        $pdf = PDF::loadView('diagnostics.forms.medicalExaminationLandbased',
            array('resultsDtl' => $resultsDtl,
                'preview_id' => $preview_id));
            $pdf->setPaper($customPaper);
            return $pdf->stream();
    }

    public function printMedExamSeabased($id, $preview_id){
        if (Auth::check()) {
            // user is logged in
            $store_id = auth()->user()->store_id;
        } else {
            return redirect()->guest(route('login'));
        }

        $resultsDtl = DB::table('diagnostic_view')


            ->leftjoin('signatories as a', 'diagnostic_view.physician', 'a.access_id')
            ->select('diagnostic_view.*', 'a.signatory as physician','a.title as title', 'a.designation as designation1', 'a.ID_description as ID1', 'a.ID_no as ID_no1', 'a.expiry_date as ID_expiry1', 'a.signature as signature1')
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

        $customPaper = array(0, 0, 600.00, (832.00));
        $pdf = PDF::loadView('diagnostics.forms.medicalExaminationSeabased',
            array('resultsDtl' => $resultsDtl,
                'preview_id' => $preview_id));
        $pdf->setPaper($customPaper);
        return $pdf->stream();
    }

    public function printMCLE($id, $preview_id){
        if (Auth::check()) {
            // user is logged in
            $store_id = auth()->user()->store_id;
        } else {
            return redirect()->guest(route('login'));
        }

        $resultsDtl = DB::table('diagnostic_view')


            ->leftjoin('signatories as a', 'diagnostic_view.physician', 'a.access_id')
            ->select('diagnostic_view.*', 'a.signatory as physician','a.title as title', 'a.designation as designation1', 'a.ID_description as ID1', 'a.ID_no as ID_no1', 'a.expiry_date as ID_expiry1', 'a.signature as signature1')
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

        $customPaper = array(0, 0, 600.00, (832.00));
        $pdf = PDF::loadView('diagnostics.forms.medicalCertificateLocalEmployment',
            array('resultsDtl' => $resultsDtl,
                'preview_id' => $preview_id));

        $pdf->setPaper($customPaper);
        return $pdf->stream();
    }

    public function printLocalEmploymentCert($id, $preview_id){

        if (Auth::check()) {
            // user is logged in
            $store_id = auth()->user()->store_id;
        } else {
            return redirect()->guest(route('login'));
        }

        $resultsDtl = DB::table('diagnostic_view')
            ->leftjoin('signatories as a', 'diagnostic_view.physician', 'a.access_id')
            ->select('diagnostic_view.*', 'a.signatory as physician','a.title as title', 'a.designation as designation1', 'a.ID_description as ID1', 'a.ID_no as ID_no1', 'a.expiry_date as ID_expiry1', 'a.signature as signature1')
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

//      Avatar
            if (!empty($resultsDtl->avatar)) {
                $avatar = 'storage/customer_image/' . $resultsDtl->avatar;
                if (@file_get_contents($avatar)) {
                    $avatar_data = file_get_contents($avatar);
                    $extencion = pathinfo($avatar, PATHINFO_EXTENSION);
                    $avatar_base_64 = base64_encode($avatar_data);
                    $avatar_img = 'data:image/' . $extencion . ';base64,' . $avatar_base_64;
                    $resultsDtl->avatar = $avatar_img;
                }
            }
        }

        $customPaper = array(0, 0, 612.00, (936.00));
        $pdf = PDF::loadView('diagnostics.forms.LocalEmploymentCertificate',
        array('resultsDtl' => $resultsDtl,
            'preview_id' => $preview_id));
        $pdf->setPaper($customPaper);
        return $pdf->stream();
    }

    public function transmittal_report()
    {
        if (Auth::check()) {
            // user is logged in
            $user_class = auth()->user()->class;
            $storeID = auth()->user()->store_id;
        } else {
            // user is logged in
            return redirect()->guest(route('login'));
        }

        $start_date = Carbon::today()->format('Y-m-d');
        $end_date = Carbon::today()->format('Y-m-d');

        $order = Order::whereDate('created_at', '>=', $start_date)->whereDate('created_at', '<=' , $end_date)->get();

        $start_date = Carbon::today()->format('Y-m-d');
        $end_date = Carbon::today()->format('Y-m-d');

        $daystosum = '1';
        $new_end_date = date('Y-m-d', strtotime($end_date.' + '.$daystosum.' days'));

        $reception = Order::whereDate('created_at', '>=', $start_date)->whereDate('created_at', '<=' , $new_end_date)->count();
        $newStatus = Order::where('orders.status','New')->whereDate('created_at', '>=', $start_date)->whereDate('created_at', '<=' , $new_end_date)->count();
        $inProcess = Order::where('status', 'In process')->whereDate('created_at', '>=', $start_date)->whereDate('created_at', '<=' , $new_end_date)->count();
        $cancelled = Order::where('status', 'Cancelled')->whereDate('created_at', '>=', $start_date)->whereDate('created_at', '<=' , $new_end_date)->count();
        $forPatho = Order::where('status', 'For Dept Heads Approval')->whereDate('created_at', '>=', $start_date)->whereDate('created_at', '<=' , $new_end_date)->count();
        $forPhysician = Order::where('status', 'For Physicians Approval')->whereDate('created_at', '>=', $start_date)->whereDate('created_at', '<=' , $new_end_date)->count();
        $forMedDirector = Order::where('status', 'For Directors Approval')->whereDate('created_at', '>=', $start_date)->whereDate('created_at', '<=' , $new_end_date)->count();
        $forRelease = Order::where('status', 'Completed')->whereDate('created_at', '>=', $start_date)->whereDate('created_at', '<=' , $new_end_date)->count();

        $released = Order::where('status', 'Released')->whereDate('released_date', '>=', $start_date)->whereDate('released_date', '<=' , $new_end_date)->count();

        $local = Order::with('client', 'detail')->whereHas('client', function ($q) {$q->where('customers.application_type','Local')->whereNotNull('id');})->whereDate('created_at', '>=', $start_date)->whereDate('created_at', '<=' , $new_end_date)->count();

        $landbased = Order::with('client', 'detail')->whereHas('client', function ($q) {$q->where('customers.application_type','Land based')->whereNotNull('id');})->whereDate('created_at', '>=', $start_date)->whereDate('created_at', '<=' , $new_end_date)->count();

        $seabased = Order::with('client', 'detail')->whereHas('client', function ($q) {$q->where('customers.application_type','Sea based')->whereNotNull('id');})->whereDate('created_at', '>=', $start_date)->whereDate('created_at', '<=' , $new_end_date)->count();

        $partner_list = Partner::orderBy('id')->pluck('partner','id');

        return view('diagnostics.forms.transmittal_report')
            ->with('order', $order)
            ->with('reception', $reception)
                ->with('newStatus', $newStatus)
               ->with('cancelled', $cancelled)
                ->with('inProcess', $inProcess)
                ->with('forPatho', $forPatho)
                ->with('forPhysician', $forPhysician)
                ->with('forMedDirector', $forMedDirector)
                ->with('forRelease', $forRelease)
                ->with('released', $released)
                ->with('start_date', $start_date)
                ->with('end_date', $end_date)
                ->with('new_end_date', $new_end_date)
                ->with('local', $local)
                ->with('landbased', $landbased)
                ->with('seabased', $seabased)
                ->with('partner_list',$partner_list)
                ->with('partner',0);

    }

    public function transmittal_report_period($partner, $start_date, $end_date)
    {
        if (Auth::check()) {
            // user is logged in
            $user_class = auth()->user()->class;
            $storeID = auth()->user()->store_id;
        } else {
            // user is logged in
            return redirect()->guest(route('login'));
        }

        /*$order = Order::with('client', 'detail', 'packageResults')->whereHas('client', function ($q) use ($partner) {$q->where('referring_institution', $partner);})->whereDate('created_at', '>=', $start_date)->whereDate('created_at', '<=' , $end_date)->get();*/

        $daystosum = '1';
        $new_end_date = date('Y-m-d', strtotime($end_date.' + '.$daystosum.' days'));

        $order = Order::with('clients', 'detail', 'packageResults')
            ->whereHas('client', function ($q) use ($partner) {$q->where('referring_institution', $partner);})
            ->whereHas('detail', function ($q) {$q->join('items','items.id','order_detail.item_id')->where('items.bundled',1);})
            ->whereDate('orders.created_at', '>=', $start_date)
            ->whereDate('orders.created_at', '<=' , $new_end_date)->get();

        $newStatus = Order::with('client', 'detail', 'packageResults')->whereHas('client', function ($q) use ($partner) {$q->where('referring_institution', $partner);})->where('orders.status','New')->whereHas('detail', function ($q) {$q->join('items','items.id','order_detail.item_id')->where('items.bundled',1);})->whereDate('created_at', '>=', $start_date)->whereDate('created_at', '<=' , $new_end_date)->count();
        $inProcess = Order::with('client', 'detail', 'packageResults')->whereHas('client', function ($q) use ($partner) {$q->where('referring_institution', $partner);})->where('status', 'In process')->whereHas('detail', function ($q) {$q->join('items','items.id','order_detail.item_id')->where('items.bundled',1);})->whereDate('created_at', '>=', $start_date)->whereDate('created_at', '<=' , $new_end_date)->count();
        $cancelled = Order::with('client', 'detail', 'packageResults')->whereHas('client', function ($q) use ($partner) {$q->where('referring_institution', $partner);})->where('status', 'Cancelled')->whereHas('detail', function ($q) {$q->join('items','items.id','order_detail.item_id')->where('items.bundled',1);})->whereDate('created_at', '>=', $start_date)->whereDate('created_at', '<=' , $new_end_date)->count();
        $forPatho = Order::with('client', 'detail', 'packageResults')->whereHas('client', function ($q) use ($partner) {$q->where('referring_institution', $partner);})->where('status', 'For Dept Heads Approval')->whereHas('detail', function ($q) {$q->join('items','items.id','order_detail.item_id')->where('items.bundled',1);})->whereDate('created_at', '>=', $start_date)->whereDate('created_at', '<=' , $new_end_date)->count();
        $forPhysician = Order::with('client', 'detail', 'packageResults')->whereHas('client', function ($q) use ($partner) {$q->where('referring_institution', $partner);})->where('status', 'For Physicians Approval')->whereHas('detail', function ($q) {$q->join('items','items.id','order_detail.item_id')->where('items.bundled',1);})->whereDate('created_at', '>=', $start_date)->whereDate('created_at', '<=' , $new_end_date)->count();
        $forMedDirector = Order::with('client', 'detail', 'packageResults')->whereHas('client', function ($q) use ($partner) {$q->where('referring_institution', $partner);})->where('status', 'For Directors Approval')->whereHas('detail', function ($q) {$q->join('items','items.id','order_detail.item_id')->where('items.bundled',1);})->whereDate('created_at', '>=', $start_date)->whereDate('created_at', '<=' , $new_end_date)->count();
        $forRelease = Order::with('client', 'detail', 'packageResults')->whereHas('client', function ($q) use ($partner) {$q->where('referring_institution', $partner);})->where('status', 'Completed')->whereHas('detail', function ($q) {$q->join('items','items.id','order_detail.item_id')->where('items.bundled',1);})->whereDate('created_at', '>=', $start_date)->whereDate('created_at', '<=' , $new_end_date)->count();
        $released = Order::with('client', 'detail', 'packageResults')->whereHas('client', function ($q) use ($partner) {$q->where('referring_institution', $partner);})->where('status', 'Released')->whereHas('detail', function ($q) {$q->join('items','items.id','order_detail.item_id')->where('items.bundled',1);})->whereDate('created_at', '>=', $start_date)->whereDate('created_at', '<=' , $new_end_date)->count();

        $partner_list = Partner::orderBy('id')->pluck('partner','id');

        return view('diagnostics.forms.transmittal_report')
            ->with('order', $order)
            ->with('newStatus', $newStatus)
            ->with('cancelled', $cancelled)
            ->with('inProcess', $inProcess)
            ->with('forPatho', $forPatho)
            ->with('forPhysician', $forPhysician)
            ->with('forMedDirector', $forMedDirector)
            ->with('forRelease', $forRelease)
            ->with('released', $released)
            ->with('start_date', $start_date)
            ->with('end_date', $end_date)
            ->with('new_end_date', $new_end_date)
            ->with('partner_list',$partner_list)
            ->with('partner',$partner);
    }

    public function transmittal($partner,$start_date, $end_date)
    {
        if (Auth::check()) {
            // user is logged in
            $user_class = auth()->user()->class;
            $storeID = auth()->user()->store_id;
        } else {
            // user is logged in
            return redirect()->guest(route('login'));
        }

        /*$order = Order::with('client', 'detail', 'packageResults')->whereHas('client', function ($q) use ($partner) {$q->where('referring_institution', $partner);})
            ->whereHas('detail', function ($q) {$q->where('detail.item_id','results.item_id');})
            ->whereDate('created_at', '>=', $start_date)->whereDate('created_at', '<=' , $end_date)->get();*/

        $daystosum = '1';
        $new_end_date = date('Y-m-d', strtotime($end_date.' + '.$daystosum.' days'));

        $order = Order::with('client', 'detail', 'packageResults')
            ->join('customers','customers.id', 'orders.customer_id')
            ->select('orders.id','orders.customer_id','orders.status','customers.name','customers.position_applied','customers.mobile_no','customers.email','customers.vessel')
            ->orderBy('customers.name', 'asc')
            ->whereHas('client', function ($q) use ($partner) {$q->where('referring_institution', $partner);})
            ->whereHas('detail', function ($q) {$q->join('items','items.id','order_detail.item_id')->where('items.bundled',1);})
            ->whereDate('orders.created_at', '>=', $start_date)
            ->whereDate('orders.created_at', '<=' , $new_end_date)->get();

        $newStatus = Order::with('client', 'detail', 'packageResults')->whereHas('client', function ($q) use ($partner) {$q->where('referring_institution', $partner);})->where('orders.status','New')->whereHas('detail', function ($q) {$q->join('items','items.id','order_detail.item_id')->where('items.bundled',1);})->whereDate('created_at', '>=', $start_date)->whereDate('created_at', '<=' , $new_end_date)->count();
        $inProcess = Order::with('client', 'detail', 'packageResults')->whereHas('client', function ($q) use ($partner) {$q->where('referring_institution', $partner);})->where('status', 'In process')->whereHas('detail', function ($q) {$q->join('items','items.id','order_detail.item_id')->where('items.bundled',1);})->whereDate('created_at', '>=', $start_date)->whereDate('created_at', '<=' , $new_end_date)->count();
        $cancelled = Order::with('client', 'detail', 'packageResults')->whereHas('client', function ($q) use ($partner) {$q->where('referring_institution', $partner);})->where('status', 'Cancelled')->whereHas('detail', function ($q) {$q->join('items','items.id','order_detail.item_id')->where('items.bundled',1);})->whereDate('created_at', '>=', $start_date)->whereDate('created_at', '<=' , $new_end_date)->count();
        $forPatho = Order::with('client', 'detail', 'packageResults')->whereHas('client', function ($q) use ($partner) {$q->where('referring_institution', $partner);})->where('status', 'For Dept Heads Approval')->whereHas('detail', function ($q) {$q->join('items','items.id','order_detail.item_id')->where('items.bundled',1);})->whereDate('created_at', '>=', $start_date)->whereDate('created_at', '<=' , $new_end_date)->count();
        $forPhysician = Order::with('client', 'detail', 'packageResults')->whereHas('client', function ($q) use ($partner) {$q->where('referring_institution', $partner);})->where('status', 'For Physicians Approval')->whereHas('detail', function ($q) {$q->join('items','items.id','order_detail.item_id')->where('items.bundled',1);})->whereDate('created_at', '>=', $start_date)->whereDate('created_at', '<=' , $new_end_date)->count();
        $forMedDirector = Order::with('client', 'detail', 'packageResults')->whereHas('client', function ($q) use ($partner) {$q->where('referring_institution', $partner);})->where('status', 'For Directors Approval')->whereHas('detail', function ($q) {$q->join('items','items.id','order_detail.item_id')->where('items.bundled',1);})->whereDate('created_at', '>=', $start_date)->whereDate('created_at', '<=' , $new_end_date)->count();
        $forRelease = Order::with('client', 'detail', 'packageResults')->whereHas('client', function ($q) use ($partner) {$q->where('referring_institution', $partner);})->where('status', 'Completed')->whereHas('detail', function ($q) {$q->join('items','items.id','order_detail.item_id')->where('items.bundled',1);})->whereDate('created_at', '>=', $start_date)->whereDate('created_at', '<=' , $new_end_date)->count();

        $released = Order::with('client')->whereHas('client', function ($q) use ($partner) {$q->where('referring_institution', $partner);})->where('status', 'Released')->whereHas('detail', function ($q) {$q->join('items','items.id','order_detail.item_id')->where('items.bundled',1);})->whereDate('created_at', '>=', $start_date)->whereDate('created_at', '<=' , $new_end_date)->count();

        $partner_list = Partner::orderBy('id')->pluck('partner','id');

        //$customPaper = array(0, 0, 612.00, (936.00));
        $customPaper = array(0, 0, 600.00, (832.00));
        $pdf = PDF::loadView('diagnostics.forms.TransmittalReport',
            array(
                'order' => $order,
                'newStatus' => $newStatus,
                'cancelled' => $cancelled,
                'inProcess' => $inProcess,
                'forPatho' => $forPhysician,
                'forPhysician' => $forPhysician,
                'forMedDirector' => $forMedDirector,
                'forRelease' => $forRelease,
                'released' => $released,
                'start_date' => $start_date,
                'end_date' => $end_date,
                'new_end_date' => $new_end_date,
                'partner_list' => $partner_list));
        $pdf->setPaper($customPaper, 'landscape');
        return $pdf->stream();
    }

    public function ConsultationResultsPreview($preview_id)
    {
        if (Auth::check()) {
            $store_id = auth()->user()->store_id;
            $user_class = auth()->user()->class;
        } else {
            $store_id = "1";
        }

        // save as PDF

        $resultsDtl = DB::table('diagnostic_view')
            ->leftjoin('signatories as a', 'diagnostic_view.approved_by', 'a.access_id')
            ->select('diagnostic_view.name', 'diagnostic_view.suffix', 'diagnostic_view.gender', 'diagnostic_view.civil_status', 'diagnostic_view.age', 'diagnostic_view.birthday', 'diagnostic_view.civil_status', 'diagnostic_view.address', 'diagnostic_view.pdf', 'diagnostic_view.preview_id', 'diagnostic_view.med_exam_date',  'diagnostic_view.approved_date', 'diagnostic_view.results as results', 'diagnostic_view.recommendations as recommendations', 'a.signatory as approved_by','a.title as title', 'a.designation as designation1', 'a.ID_description as ID1', 'a.ID_no as ID_no1', 'a.expiry_date as ID_expiry1', 'a.signature as signature1')
            ->where('diagnostic_view.store_id', $store_id)
            ->where('diagnostic_view.preview_id', $preview_id)
            ->first();

        //dd($resultsDtl);

        if ($resultsDtl) {
            $companyProfile = DB::table('profiles')
                ->where('profiles.id', $store_id )->get();

//      Signature
            if(!empty($resultsDtl->signature1)){
                $signature1 = 'storage/signatory_image/'.$resultsDtl->signature1;
                if(@file_get_contents($signature1)){
                    $signature1_data = file_get_contents($signature1);
                    $extension = pathinfo($signature1, PATHINFO_EXTENSION);
                    $signature1_base_64 = base64_encode($signature1_data);
                    $signature1_img = 'data:image/' . $extension . ';base64,' . $signature1_base_64;
                    $resultsDtl->signature1 = $signature1_img;
                }
            }

            $customPaper = array(0, 0, 297.64, 420.95);
            $pdf = PDF::loadView('diagnostics.forms.ConsultationResults', array('resultsDtl' => $resultsDtl, 'companyProfile' => $companyProfile));
            Storage::put('public/results_pdf/'.$resultsDtl->pdf, $pdf->output());

            $pdf->setPaper($customPaper);
            return $pdf->stream();

        } else {
            return view('pos.resultsPrintPreviewUnavailable');
        }

    }
}
