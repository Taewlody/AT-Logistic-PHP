<div wire:ignore>
    <select data-placeholder="{{$placeholder}}" name="{{$name}}" id="{{$this->__id}}" @class($class) wire:model.change="value" 
        @required($required) @readonly($readonly) @disabled($disabled)>
        <option></option> 
        @foreach ($options as $option)
            @if($option[$itemKey] != null|| $option[$itemKey] != "" )
                <option value="{{$option[$itemKey]}}">{{$option[$itemValue]}}</option>
            @endif
        @endforeach
    </select>
</div>

@script
<script>
    $('#{{$this->__id}}').on('change', function (e) {
        var data = $('#{{$this->__id}}').select2("val");
        @this.set('value', data);
    });
</script>
@endscript
