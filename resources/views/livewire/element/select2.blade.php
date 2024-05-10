<div wire:ignore>
    <select name="{{$name}}" id="{{$this->__id}}" @class($class) {{$multiple ? 'multiple' : ''}} {{$changefn != '' ? 'wire:change='.'"'.'$parent.'.$changefn.'"' : ''}}
        @required($required) @readonly($readonly) @disabled($disabled)>
        <option></option> 
        @if ($hasNan)
            <option value="{{$valueNan}}" @selected($value == $valueNan)>{{$textNan}}</option>
        @endif
        @foreach ($options as $option)
            @if($option[$itemKey] != null && $option[$itemKey] != "" )
                <option value="{{$option[$itemKey]}}" @selected($multiple ? isset($value)&&in_array($option[$itemKey], $value) : $value == $option[$itemKey])>{{$option[$itemValue]}}</option>
            @endif
        @endforeach
    </select>
</div>

@script
<script>
    $('#{{$this->__id}}').select2({
        placeholder: '{{$placeholder}}',
        // multiple: $wire.multiple ? true : false,
        minimumResultsForSearch: $wire.searchable ? 0 : Infinity,
    });
    $('#{{$this->__id}}').on('change', function (e) {
        var data = $(this).val();
        if(data) {
            @this.set('value', data);
            $wire.dispatch('updated-' + $wire.name, {value: data});
            $wire.dispatchSelf('change', data);
            console.log('change item: {{$this->__id}} ->', data)
        }else {
            console.log('select2 not found');
        }
    });
    
    Livewire.on('change-select2-' + $wire.name, (data) => {
        $('#{{$this->__id}}').val(data).trigger('change');
        console.log('change-select2-'+ $wire.name, data);
    });

    Livewire.on('reset-select2-' + $wire.name, () => {
        $('#{{$this->__id}}').val('').trigger('change');
    });
</script>
@endscript
