<div wire:ignore>
    <select name="{{$name}}" id="{{$this->__id}}" @class($class) 
        @required($required) @readonly($readonly) @disabled($disabled)>
        <option></option> 
        @foreach ($options as $option)
            @if($option[$itemKey] != null|| $option[$itemKey] != "" )
                <option value="{{$option[$itemKey]}}" @selected($value == $option[$itemKey])>{{$option[$itemValue]}}</option>
            @endif
        @endforeach
    </select>
</div>

@script
<script>
    $('#{{$this->__id}}').select2({
        placeholder: '{{$placeholder}}',
        // allowClear: true,
        // width: '100%',
        // theme: 'bootstrap5',
        // dropdownAutoWidth: true,
        minimumResultsForSearch: $wire.searchable ? 0 : Infinity,
        // dropdownParent: $('#{{$this->__id}}').parent()
    });
    $('#{{$this->__id}}').on('change', function (e) {
        // console.log('change item: {{$this->__id}} ->', e.target.value)
        @this.set('value', e.target.value);
    });
</script>
@endscript
