<div>
    <livewire:component.page-heading title_main="Company" title_sub="บริษัท" breadcrumb_title="Common Data"
        breadcrumb_page="Company" breadcrumb_page_title="Company Form" />

    <div class="container-fluid">
        <!-- Body-->

        {{-- loading --}}
        <div wire:loading.flex class="loader-wrapper" wire:target='save'>
            <div class="loader"></div>
        </div>

        <div class="card ">
            <div class="card-body">
                <form class="form-body" wire:submit="save" onkeydown="return event.key != 'Enter';">
                    <div class="form-group  row">
                        <label class="col-sm-2 col-form-label">
                            <h3>Company</h3>
                        </label>
                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="form-group  row">
                        <label class="col-sm-2 col-form-label">Company Name</label>
                        <div class="col-6">
                            <input type="text" class="form-control" wire:model="data.comname">
                        </div>
                    </div>
                    <div class="form-group  row">
                        <label class="col-sm-2 col-form-label">Company Name EN</label>
                        <div class="col-6">
                            <input type="text" class="form-control" wire:model="data.comnameEN">
                        </div>
                    </div>
                    <div class="form-group  row">
                        <label class="col-sm-2 col-form-label">Tax ID</label>
                        <div class="col-6">
                            <input type="text" class="form-control" wire:model="data.taxID">
                        </div>
                    </div>
                    <div class="form-group  row">
                        <label class="col-sm-2 col-form-label">Address TH</label>
                        <div class="col-6">
                            <textarea rows="4" class="form-control" wire:model="data.address"></textarea>
                        </div>
                    </div>
                    <div class="form-group  row">
                        <label class="col-sm-2 col-form-label">Address EN</label>
                        <div class="col-6">
                            <textarea rows="4" class="form-control" wire:model="data.address_en"></textarea>
                        </div>
                    </div>
                    <div class="form-group  row">
                        <label class="col-sm-2 col-form-label">Telephone</label>
                        <div class="col-6">
                            <input type="text" class="form-control" wire:model="data.telephone">
                        </div>
                    </div>
                    <div class="form-group  row">
                        <label class="col-sm-2 col-form-label">Fax</label>
                        <div class="col-6">
                            <input type="text" class="form-control" wire:model="data.fax">
                        </div>
                    </div>
                    <div class="form-group  row">
                        <label class="col-sm-2 col-form-label">Logo</label>
                        <div class="col-4">
                            <input type="file" class="form-control" wire:model="photo">
                            @error('photo') <span class="error">{{ $message }}</span> @enderror
                            <div class="preview-logo">
                                @if($photo)
                                <img class="logo" src="{{ $photo->temporaryUrl() }}">
                                @else
                                <img class="logo" src="{{ $data->logoBase64 }}">
                                @endif
                            </div>
                            
                        </div>
                    </div>
                    
                    <div class="hr-line-dashed"></div>
                    <div class="form-group row">
                        <div class="col-sm-4 col-sm-offset-2">
                            {{-- <a name="back" class="btn btn-white" type="button" href="{{ route('dashboard') }}"
                                wire.loading.attr="disabled">
                                <i class="fa fa-reply"></i> Back
                            </a> --}}
                            <button name="save" id="save" class="btn btn-primary" wire.loading.attr="disabled"
                                type="submit">
                                <i class="fa fa-save"></i> Save
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('css')
    <style>
        .preview-logo {
            padding: 20px;
        }
        img.logo {
            width: 100px;
            /* height: 100px; */
        }
    </style>
@endpush