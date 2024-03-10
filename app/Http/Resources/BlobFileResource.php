<?php

namespace App\Http\Resources;

use App\Http\Controllers\Controller;
use App\Models\AttachFile;
use Illuminate\Http\Client\Request;


class BlobFileResource extends Controller
{
    public static function viewFile(string $filename){

        $attach = AttachFile::where('filename', $filename)->first();
        if($attach){
            return response($attach->blobfile)->header('Content-Type', $attach->mimetype);
        }else{
            return response('File not found', 404);
        }
    }
    
}