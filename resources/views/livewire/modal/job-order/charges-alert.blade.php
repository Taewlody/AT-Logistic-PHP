<div>
    <div id="charges-alert" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="charges-alert"
    aria-hidden="true" @class(['modal fade']) aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLongTitle">Charges Alert</h5>
            </div>
            <div class="modal-body text-center">
                <div class="mt-2 mb-4">
                    <i class="fa fa-warning fs-1" style="color: #FFD43B;"></i>
                </div>
                <p class="fs-6">Bill of receipt มีค่า น้อยกว่า Cost <br> กรุณาตรวจสอบความถูกต้อง</p>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-success" data-bs-dismiss="modal" id="confirmModal" >ยืนยัน</button>
              <button type="button" class="btn btn-danger" data-bs-dismiss="modal" id="closeModal">ยกเลิก</button>
            </div>
          </div>
        </div>
      </div>
</div>

@script
<script>
    let link = '';
    Livewire.on('modal.job-order.charges-alert', ({showModal, confirmTo}) => {
      console.log('confirmTo: ', confirmTo);
      link = confirmTo;
        if(showModal == undefined) {
            $('#charges-alert').modal('toggle');
        } else {
            if(showModal) {
                $('#charges-alert').modal('show');
            } else {
                $('#charges-alert').modal('hide');
            }
        }

        
      });
      $('#confirmModal').click(function () {
        console.log('link: ', link);
        if(link) {
          $wire.dispatch(link);
        }
      })

    

    
</script>

@endscript
