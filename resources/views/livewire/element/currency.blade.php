<div>
    <input type="text" class="{{$class}}" id="mask-currency-{{$name}}" name="{{$name}}" value="{{$value}}" @disabled($disabled) @readonly($readonly)>
    <input type="hidden" name="{{$name}}" wire:model="value">
</div>
@script
<script>
    $("#mask-currency-{{$name}}").mask("#,###", {reverse: true});
    $("#mask-currency-{{$name}}").on('input', function(e) {
        const data = $(this).val().replace(/[^0-9\.]/g, '');
        if(data) {
            @this.call('getValue', data);
            console.log('change item: {{$name}} ->', data)
        }else {
            console.log('currency not found');
        }
    });
</script>
@endscript