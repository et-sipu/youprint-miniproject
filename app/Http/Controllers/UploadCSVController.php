<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\UploadedFiles;

class UploadCSVController extends Controller
{
    public function submit(Request $request){
        $uploadId = $this->upload($request);
        return view('index');
    }

    private function upload(Request $request)
    {
      $uploadedFile = $request->file('file');
      $filename = time().$uploadedFile->getClientOriginalName();

      Storage::disk('local')->putFileAs(
        'files/'.$filename,
        $uploadedFile,
        $filename
      );

      $upload = new UploadedFiles;
      $upload->file_name = $filename;

      $upload->save();

      return response()->json([
        'id' => $upload->id
      ]);
    }
}
