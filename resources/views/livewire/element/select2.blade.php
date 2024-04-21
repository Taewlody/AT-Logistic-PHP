<div wire:ignore>
    <select name="{{$name}}" id="{{$this->__id}}" @class($class) {{$multiple ? 'multiple' : ''}}
        @required($required) @readonly($readonly) @disabled($disabled)>
        <option></option> 
        @foreach ($options as $option)
            @if($option[$itemKey] != null|| $option[$itemKey] != "" )
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
        // console.log('change item: {{$this->__id}} ->', e.target.value)
        if($(this).data('select2')) {
            let data = $(this).select2('val');
            @this.set($wire.nameKey, data);
        }else {
            console.log('select2 not found');
        }
        
        // @this.set('value', e.target.value);
    });
</script>
@endscript
