<div>

    <livewire:component.page-heading title_main="Messenger Booking" breadcrumb_title="Messenger"
        breadcrumb_page="Messenger Booking" breadcrumb_page_title="Messenger Booking Form" />

    <div class="wrapper wrapper-content animated fadeInRight">

        {{-- loading --}}
        <div wire:loading.flex class="loader-wrapper">
            <div class="loader"></div>
        </div>

        <form class="form-body" wire:submit="save">
            
        </form>
    </div>

</div>
