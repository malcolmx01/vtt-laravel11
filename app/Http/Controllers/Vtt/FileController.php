<?php

namespace App\Http\Controllers\Vtt;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use File;
use Response;

class FileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function downloadLabIDFile(Request $request)
    {
        $laboratory_id =  $request->labID ?? 'None';

        $data[] = json_encode($laboratory_id);
        $file = "lab_id".".txt";

        $destinationPath=public_path()."/Barcodes/";
        if (!is_dir($destinationPath)) {  mkdir($destinationPath,0775,true);  }
        File::put($destinationPath.$file,$data);

        $filePath = $destinationPath.$file;
        $headers = ['Content-Type'=> 'text/plain','Content-Length'=>sizeof($data)];
        return response()->download($filePath, $file, $headers);

    }


    public function downloadSpecimenIDFile(Request $request)
    {
        $specimen_id =  $request->specimenID ?? 'None';

        $data[] = json_encode($specimen_id);
        $file = "specimen_id".".txt";

        $destinationPath=public_path()."/Barcodes/";
        if (!is_dir($destinationPath)) {  mkdir($destinationPath,0775,true);  }
        File::put($destinationPath.$file,$data);

        $filePath = $destinationPath.$file;
        $headers = ['Content-Type'=> 'text/plain','Content-Length'=>sizeof($data)];
        return response()->download($filePath, $file, $headers);
    }

    public function downloadLabID($id)
    {
        $data[] = json_encode($id);
        $file = "lab_id".".txt";

        $destinationPath=public_path()."/Barcodes/";
        if (!is_dir($destinationPath)) {  mkdir($destinationPath,0775,true);  }
        File::put($destinationPath.$file,$data);

        $filePath = $destinationPath.$file;
        $headers = ['Content-Type'=> 'text/plain','Content-Length'=>sizeof($data)];
        return response()->download($filePath, $file, $headers);

    }


    public function downloadSpecimenID($id)
    {
        $data[] = json_encode($id);
        $file = "specimen_id".".txt";

        $destinationPath=public_path()."/Barcodes/";
        if (!is_dir($destinationPath)) {  mkdir($destinationPath,0775,true);  }
        File::put($destinationPath.$file,$data);

        $filePath = $destinationPath.$file;
        $headers = ['Content-Type'=> 'text/plain','Content-Length'=>sizeof($data)];
        return response()->download($filePath, $file, $headers);
    }
}
