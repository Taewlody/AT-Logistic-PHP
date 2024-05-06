<div>
    <div id="modal-alert" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="charges-alert"
    aria-hidden="true" @class(['modal fade']) aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
          <div class="modal-content">
            <div class="modal-header">
                <div class="mt-2 mb-4">
                    <i class="fa-light fa-circle-check" style="color: #19c876;"></i>
                </div>
            </div>
            <div class="modal-body text-center">
                <h5 class="modal-title" id="exampleModalLongTitle">Success</h5>
                <p id="" class="fs-6">บันทึกข้อมูลสำเร็จ</p>
            </div>
          </div>
        </div>
      </div>
</div>
@script
<script>
    Livewire.on('modal.common.modal-alert', ({showModal, autoClose, message, type}) => {
        if(showModal == undefined) {
            $('#modal-alert').modal('toggle');
        } else {
            if(showModal) {
                $('#modal-alert').modal('show');
            } else {
                $('#modal-alert').modal('hide');
            }
        }
    });
</script>

@endscript