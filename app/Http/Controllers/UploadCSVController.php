<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\UploadedFiles;
use App\Jobs\UploadCSV;
use Illuminate\Support\Facades\Bus;

class UploadCSVController extends Controller
{
    public function submit(Request $request){

        $file = $request->file('file');
        $filename = time().$file->getClientOriginalName();
        $fileDir = 'files/'.$filename;

        $upload = new UploadedFiles;
        $upload->file_name = $filename;

        if($upload->save()){
          // Store file into Storage
          Storage::disk('local')->putFileAs(
            $fileDir,
            $file,
            $filename
          );

          // Call job queue
          UploadCSV::dispatch($filename);
        }else{
          exit("Error");
        }
  
        return redirect('/');
    }
}
