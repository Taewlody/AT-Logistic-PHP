<div>

    <livewire:component.page-heading title_main="User" title_sub="ผู้ใช้งาน" breadcrumb_title="Common Data" breadcrumb_page="User" breadcrumb_page_title="User Form" />

    <div class="wrapper wrapper-content animated fadeInRight">

        {{-- loading --}}
        <div wire:loading.block class="loader-wrapper">
            <div class="loader"></div>
        </div>

        <form class="form-body" wire:submit="save">
            
        </form>
    </div>

</div>
