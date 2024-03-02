<div>
    <input type="{{$type}}" class="form-control"  wire:key="{{$keyName}}" wire:model.live="value" >
    @error('input') 
        <span class="invalid-feedback">{{ $message }}</span>
    @enderror
</div>
