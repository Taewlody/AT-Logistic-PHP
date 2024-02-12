<div>

    <livewire:component.page-heading title_main="Petty Cash" title_sub="เงินสดย่อย" title_sub="เงินสดย่อย" breadcrumb_title="Account"
        breadcrumb_page="Petty Cash" breadcrumb_page_title="Petty Cash Form" />
    
    <div class="wrapper wrapper-content animated fadeInRight">

        {{-- loading --}}
        <div wire:loading.block class="loader-wrapper">
            <div class="loader"></div>
        </div>

        <form class="form-body" wire:submit="save">
            
        </form>
    </div>

</div>
