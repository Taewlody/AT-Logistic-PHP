<div>

    <livewire:component.page-heading title_main="Commodity" title_sub="สินค้า" breadcrumb_title="Common Data"
        breadcrumb_page="Commodity" />


    <div class="container-fluid">
        <div class="card ">
            <div class="card-body">
                <form class="form-body" wire:submit="save">
                    <div class="form-group  row">
                        <label class="col-sm-2 col-form-label">
                            <h3>Commodity info</h3>
                        </label>

                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label"> Code</label>
                        <div class="col-md-2">
                            <input type="text" class="form-control" wire:model="data.commodityCode" @disabled($action
                                !='create' )>
                        </div>
                    </div>
                    <div class="form-group  row"><label class="col-sm-2 col-form-label"> Name (TH)</label>
                        <div class="col-sm-8"><input name="commodityNameTH" type="text" class="form-control "
                                id="commodityNameTH" wire:model="data.commodityNameTH" @disabled($action !='create' &&
                                $action !='edit' )>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label"> Name (EN)</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control " name="commodityNameEN" autocomplete="off"
                                id="commodityNameEN" wire:model="data.commodityNameEN" @disabled($action !='create' &&
                                $action !='edit' )>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Status</label>
                        <div class="col-sm-10">
                            <input id="radio-active" type="radio" wire:model.boolean="data.isActive" value="true"
                                @disabled($action !='create' && $action !='edit' )>
                            <label for="radio-active" class="checkbox-inline i-checks">Active </label>

                            <input id="radio-inactive" type="radio" wire:model.boolean="data.isActive" value="false"
                                @disabled($action !='create' && $action !='edit' )>
                            <label for="radio-inactive" class="i-checks">Inactive</label>

                        </div>
                    </div>
                    @if($action != 'create')
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Create By</label>
                        <div class="col-sm-10">
                            <label>{{ $data->createBy->username }} {{$data->createTime ?? ''}}</label>
                        </div>
                    </div>

                    <div class="form-group  row">
                        <label class="col-sm-2 col-form-label">Update By</label>
                        <div class="col-sm-10">
                            <label>{{ $data->editBy->username }} {{$data->editTime ?? ''}}</label>
                        </div>
                    </div>
                    @endif
                    <div class="hr-line-dashed"></div>

                    <div class="form-group row">
                        <div class="col-sm-4 col-sm-offset-2">
                            <a name="back" class="btn btn-white" type="button" href="{{route('commodity')}}">
                                <i class="fa fa-reply"></i> Back</a>
                            @if ($action == 'create' || $action == 'edit')
                            <button name="save" id="save" class="btn btn-primary" type="submit"><i
                                    class="fa fa-save"></i> Save</button>
                            @endif
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>