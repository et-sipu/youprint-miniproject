<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\UploadedFiles;
use Illuminate\Http\Request;
use App\Transformers\FileTransformer;

class File extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $files = UploadedFiles::select('id','created_at','file_name','status')->orderByDesc('id')->get();
        //return $files;
        return fractal()
                ->collection($files)
                ->transformWith(new FileTransformer())
                ->toArray()['data'];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
