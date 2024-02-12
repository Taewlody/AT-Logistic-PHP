<div>

    <livewire:component.page-heading title_main="Receipt Voucher" title_sub="ใบสำคัญรับ" title_sub="ใบสำคัญรับ" breadcrumb_title="Account"
        breadcrumb_page="Receipt Voucher" breadcrumb_page_title="Receipt Voucher Form" />

        <div class="wrapper wrapper-content animated fadeInRight">

            {{-- loading --}}
            <div wire:loading.block class="loader-wrapper">
                <div class="loader"></div>
            </div>
    
            <form class="form-body" wire:submit="save">
                
            </form>
        </div>

</div>
