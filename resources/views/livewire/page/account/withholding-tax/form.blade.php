<div>


    
    <div class="wrapper wrapper-content animated fadeInRight">

        {{-- loading --}}
        <div wire:loading.flex class="loader-wrapper">
            <div class="loader"></div>
        </div>

        <form class="form-body" wire:submit="save" onkeydown="return event.key != 'Enter';">
            
        </form>
    </div>

</div>
