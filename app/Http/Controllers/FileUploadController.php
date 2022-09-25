<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\TmpFile;
use Carbon\Carbon;

class FileUploadController extends Controller
{
    public function uploads(Request $request){
        if($request->hasFile($request->name)){
            $file = $request->file($request->name);
            $filename = $file->getClientOriginalName();
            $folder = uniqid();
            $file->storeAs('file/tmp/'.$folder, $filename);
            $path ="file/tmp/" . $folder;
            $url = "file/tmp/" . $folder . "/" . $filename;

            $save = new TmpFile;
            $save->path = $path;
            $save->filename = $filename;
            $save->created_at = Carbon::now()->toDateTimeString();
            $save->created_by = auth()->user()->id;
            $save->save();

            return $save->id;

        }
        return $request->name;
    }

}
