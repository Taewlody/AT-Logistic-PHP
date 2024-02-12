<div>

    <livewire:component.page-heading title_main="Invoice" title_sub="ใบแจ้งหนี้" title_sub="ใบสำคัญจ่าย" breadcrumb_title="Account"
        breadcrumb_page="Invoice" breadcrumb_page_title="Invoice Form" />

    <div class="wrapper wrapper-content animated fadeInRight">

        {{-- loading --}}
        <div wire:loading.block class="loader-wrapper">
            <div class="loader"></div>
        </div>

        <form class="form-body" wire:submit="save">
            
        </form>
    </div>

</div>
