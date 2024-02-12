<div>

    <livewire:component.page-heading title_main="User Type" title_sub="ประเภทผู้ใช้งาน" breadcrumb_title="Administrator" breadcrumb_page="User Type" breadcrumb_page_title="User Type Form" />

    <div class="wrapper wrapper-content animated fadeInRight">

        {{-- loading --}}
        <div wire:loading.block class="loader-wrapper">
            <div class="loader"></div>
        </div>

        <form class="form-body" wire:submit="save">
            
        </form>
    </div>

</div>
