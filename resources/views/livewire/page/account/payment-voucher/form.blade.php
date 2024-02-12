<div>

    <livewire:component.page-heading title_main="Payment Voucher" title_sub="ใบสำคัญจ่าย" breadcrumb_title="Account"
        breadcrumb_page="Payment Voucher" breadcrumb_page_title="Payment Voucher Form" />
    
    <div class="wrapper wrapper-content animated fadeInRight">

        {{-- loading --}}
        <div wire:loading.block class="loader-wrapper">
            <div class="loader"></div>
        </div>

        <form class="form-body" wire:submit="save">
            
        </form>
    </div>

</div>
