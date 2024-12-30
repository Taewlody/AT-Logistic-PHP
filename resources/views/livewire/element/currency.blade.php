<div>
    <input wire:ignore:self type="text" class="{{$class}}" id="{{$this->__id}}" name="{{$name}}" value="{{$value}}" @disabled($disabled) @readonly($readonly)>

    <input type="hidden" name="{{$name}}" wire:model="value">
</div>
@script
<script>
    $(document).ready(function() {
        const currencyElement = $('#{{$this->__id}}');
        // const currencyElement = $("input[name='{{$name}}']");
        // currencyElement.inputmask({
        //     alias: 'decimal',
        //     rightAlign: false,
        //     groupSeparator: ',',
        //     autoGroup: true, 
        //     integerDigits:6,
        //     autoUnmask: true,
        //     digits:2,
        //     allowMinus:false,        
        //     digitsOptional: true,
        //     placeholder: "0"
        // });
        currencyElement.on('input', function(e) {

            const data = $(this).val();
            if(data) {
                // @this.call('getValue', data);
                @this.set('value', parseFloat(data));
                console.log('change item curency:', $wire.name ,'->', data)
                // @this.dispatch('changeValue');
                console.log('charge : ', $wire.value, parseFloat(data));
                
                if($wire.name != null && $wire.name != ''){
                    $wire.dispatch('updated-' + $wire.name, {value: data});
                }
            }else {
                console.log('currency not found');
            }
            
        });
        Livewire.on('change-' + $wire.name, ({value}) => {
            if(currencyElement.val() !== value) {
                currencyElement.val(value);
                console.log('change-currency-'+ $wire.name, value);
                if(value != $wire.value) {
                    console.log('change charge: ', value, $wire.value);
                    @this.set('value', parseFloat(value));
                }
            }
        });
        
    });
</script>
@endscript