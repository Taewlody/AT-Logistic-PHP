<div>

    <livewire:component.page-heading title_main="Tax Invoice" title_sub="ใบกำกับภาษี" title_sub="ใบกำกับภาษี"
        breadcrumb_title="Account" breadcrumb_page="Tax Invoice" breadcrumb_page_title="Tax Invoice Form" />

        <div class="wrapper wrapper-content animated fadeInRight">

            {{-- loading --}}
            <div wire:loading.block class="loader-wrapper">
                <div class="loader"></div>
            </div>
    
            <form class="form-body" wire:submit="save">
                
            </form>
        </div>
        
</div>
