<?php


namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    public function upload(Request $request){
        $file_link = $request->file('file');
        if (null !== $file_link) {
            $extensionImage = $file_link->getClientOriginalExtension();
            Storage::disk('public')->put($file_link->getFilename().'.'.$extensionImage,  File::get($file_link));
        }

        if (null !== $file_link) {
            $data = [
                'path'   => $file_link->getPath(),
                'size'   => $file_link->getSize(),
                'type'   => $file_link->getMimeType(),
                'original_name'   => $file_link->getClientOriginalName(),
                'url'   => '/uploads/' . $file_link->getFilename() . '.' . $extensionImage,
            ];
            \App\File::create($data);
            return response($data);
        }
    }
}