<?php

namespace App\Http\Resources;

use App\Http\Controllers\Controller;
use App\Models\AttachFile;
use Illuminate\Http\Request;
use File;
use QueryException;


class BlobFileResource extends Controller
{
    public function fileRule(): array
    {
        return [
            'required',
           File::types(['png', 'jpg', 'jpeg', 'pdf'])
               ->max(10 * 1024),
        ];
    }

    public function viewFile(string $filename){

        $attach = AttachFile::where('filename', $filename)->first();
        if($attach){
            return response($attach->blobfile)->header('Content-Type', $attach->mimetype);
        }else{
            return response('File not found', 404);
        }
    }

    public function addFile(Request $request){
        $this->validate($request, [
            'file' => 'required|file|mimes:png,jpg,jpeg,pdf|max:102400',
        ]);
        $file = $request->file('file');
        $filename = $file->getClientOriginalName();
        $mimetype = $file->getClientMimeType();
        $blobfile = file_get_contents($file);
        $attach = new AttachFile();
        $attach->filename = $filename;
        $attach->mimetype = $mimetype;
        $attach->blobfile = $blobfile;
        try {
            $attach->save();
        } catch(\Illuminate\Database\QueryException $e) {
            $errorCode = $e->errorInfo[1];
            if($errorCode == 1062){
                return response('duplicate entry file', 500);
            }else{
                return response('Error saving file: '.$e->getMessage(), 500);
            
            }
        }
        catch (\Exception $e) {
            return response('Error saving file: '.$e->getMessage(), 500);
        }
        $attach->save();
        return response('File uploaded', 200);
    }
    
}