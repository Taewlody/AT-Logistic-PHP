<div>
    @teletport('body')
    <div id="modal-alert" data-bs-keyboard="false" tabindex="-1" role="dialog"
        aria-labelledby="charges-alert" aria-hidden="true" @class(['modal fade', 'auto-close' => $autoClose ]) aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <div class="mt-4 mb-4">
                        <i id="modal-alert-icon"></i>
                    </div>
                    <h3 id="modal-alert-title" class="modal-title" id="exampleModalLongTitle"></h3>
                    <p id="modal-alert-text" class="fs-6"></p>
                </div>
            </div>
        </div>
    </div>
    @endteleport
</div>
@script
    <script>
        Livewire.on('modal.common.modal-alert', ({
            showModal,
            title,
            message,
            type
        }) => {
            console.log('modal.common.modal-alert');   
            typeModal(type);
            if(title == undefined) title = 'Success';
            if(message == undefined) message = 'บันทึกข้อมูลสำเร็จ';
            $('#modal-alert-title').text(title);
            $('#modal-alert-text').text(message);
            if (showModal == undefined) {
                $('#modal-alert').modal('toggle');
            } else {
                if (showModal) {
                    $('#modal-alert').modal('show');
                } else {
                    $('#modal-alert').modal('hide');
                }
            }
        });

        function typeModal(type) {
            switch (type) {
                case 'success': 
                    $('#modal-alert-icon').removeClass();
                    $('#modal-alert-icon').addClass('fa fa-check-circle-o');
                    $('#modal-alert-icon').css('color', '#19c876');
                    $('#modal-alert-icon').css('font-size', '60px');
                    break;
                case 'error': 
                    $('#modal-alert-icon').removeClass();
                    $('#modal-alert-icon').addClass('fa fa-times-circle-o');
                    $('#modal-alert-icon').css('color', '#ff0000');
                    $('#modal-alert-icon').css('font-size', '60px');
                    break;
                case 'warning':
                    $('#modal-alert-icon').removeClass();
                    $('#modal-alert-icon').addClass('fa fa-exclamation-circle');
                    $('#modal-alert-icon').css('color', '#ffcc00');
                    $('#modal-alert-icon').css('font-size', '60px');
                    break;
                case 'info':
                    $('#modal-alert-icon').removeClass();
                    $('#modal-alert-icon').addClass('fa fa-info-circle');
                    $('#modal-alert-icon').css('color', '#007bff');
                    $('#modal-alert-icon').css('font-size', '60px');
                    break;
                default:
                    $('#modal-alert-icon').removeClass();
                    $('#modal-alert-icon').addClass('fa fa-info-circle');
                    $('#modal-alert-icon').css('color', '#007bff');
                    $('#modal-alert-icon').css('font-size', '60px');
                    break;
            }
        }

        $('#modal-alert').on('shown.bs.modal', function(e) {
            if ($('#modal-alert').hasClass('auto-close')) {
                setTimeout(() => {
                    if ($('#modal-alert').hasClass('show')) {
                        $('#modal-alert').modal('hide');
                    }
                }, 3000);
            }
        })
    </script>
@endscript
