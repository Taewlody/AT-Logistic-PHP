<?php

namespace App\Livewire\Page\Common\Company;

use App\Models\AttachFile;
use App\Models\Common\Company;
use Illuminate\Http\UploadedFile;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

class Form extends Component
{
    use WithFileUploads;
    public Company $data;

    #[Validate('image|max:1024')] // 1MB Max
    public $photo;

    public function mount()
    {
        $this->data = Company::first();
        // dd($this->data->logoFile);
    }


    public function save()
    {
        $this->validate();
        if($this->photo) {
            AttachFile::where('filename', $this->data->logo)->delete();
            $new_file = new AttachFile;
            $new_file->mimetype = $this->photo->getMimeType();
            $new_file->blobfile = file_get_contents($this->photo->getRealPath());
            $new_file->filename = $this->photo->getClientOriginalName();
            $new_file->save();
            $this->data->logo = $new_file->filename;
        }
        $this->data->save();
        $this->redirectRoute(name: 'dashboard', navigate: true);
    }

    public function render()
    {
        return view('livewire.page.common.company.form')->extends('layouts.main')->section('main-content');
    }
}
