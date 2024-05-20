<div>
    <input wire:ignore:self type="text" class="{{$class}}" id="mask-currency-{{$name}}" name="{{$name}}" value="{{$value}}" @disabled($disabled) @readonly($readonly)>

    <input type="hidden" name="{{$name}}" wire:model="value">
</div>
@script
<script>
    $("#mask-currency-{{$name}}").inputmask({
        alias: 'decimal',
        rightAlign: false,
        groupSeparator: ',',
        autoGroup: true, 
        integerDigits:6,
        autoUnmask: true,
        digits:2,
        allowMinus:false,        
		digitsOptional: true,
		placeholder: "0"
    });
    $("#mask-currency-{{$name}}").on('input', function(e) {

        const data = $(this).val();
        if(data) {
            // @this.call('getValue', data);
            @this.set('value', parseFloat(data));
            console.log('change item: {{$name}} ->', data)
            @this.dispatch('changeValue');
        }else {
            console.log('currency not found');
        }
        
    });
</script>
@endscript