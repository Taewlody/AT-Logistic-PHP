@push('css')
    {{-- <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet"> --}}
    {{-- <link href="{{ asset('assets/font-awesome/css/font-awesome.css') }}" rel="stylesheet"> --}}

    <link href="{{ asset('assets/css/plugins/iCheck/custom.css') }}" rel="stylesheet">

    <link href="{{ asset('assets/css/plugins/fullcalendar/fullcalendar.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/plugins/fullcalendar/fullcalendar.print.css') }}" rel='stylesheet' media='print'>

    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">

@endpush

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.7.1.slim.js" integrity="sha256-UgvvN8vBkgO0luPSUl2s8TIlOSYRoGFAX4jlCIm9Adc=" crossorigin="anonymous"></script>
    <script src="{{ asset('assets/js/plugins/fullcalendar/moment.min.js')}}"></script>
    <script src="{{ asset('assets/js/plugins/fullcalendar/fullcalendar.min.js')}}"></script>

    <script>
        $(document).ready(function() {



            // $('.i-checks').iCheck({
            //     checkboxClass: 'icheckbox_square-green',
            //     radioClass: 'iradio_square-green'
            // });

            /* initialize the external events
             -----------------------------------------------------------------*/


            $('#external-events div.external-event').each(function() {

                // store data so the calendar knows to render an event upon drop
                $(this).data('event', {
                    title: $.trim($(this).text()), // use the element's text as the event title
                    stick: true // maintain when user navigates (see docs on the renderEvent method)
                });

                // make the event draggable using jQuery UI
                $(this).draggable({
                    zIndex: 1111999,
                    revert: true, // will cause the event to go back to its
                    revertDuration: 0 //  original position after the drag
                });

            });


            /* initialize the calendar
             -----------------------------------------------------------------*/
            var date = new Date();
            var d = date.getDate();
            var m = date.getMonth();
            var y = date.getFullYear();

            $('#calendar').fullCalendar({
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'month,agendaWeek,agendaDay'
                },
                editable: true,
                droppable: true, // this allows things to be dropped onto the calendar
                drop: function() {
                    // is the "remove after drop" checkbox checked?
                    if ($('#drop-remove').is(':checked')) {
                        // if so, remove the element from the "Draggable Events" list
                        $(this).remove();
                    }
                },
                events: [{
                        title: 'All Day Event',
                        start: new Date(y, m, 1)
                    },
                    {
                        title: 'Long Event',
                        start: new Date(y, m, d - 5),
                        end: new Date(y, m, d - 2)
                    },
                    {
                        id: 999,
                        title: 'Repeating Event',
                        start: new Date(y, m, d - 3, 16, 0),
                        allDay: false
                    },
                    {
                        id: 999,
                        title: 'Repeating Event',
                        start: new Date(y, m, d + 4, 16, 0),
                        allDay: false
                    },
                    {
                        title: 'Meeting',
                        start: new Date(y, m, d, 10, 30),
                        allDay: false
                    },
                    {
                        title: 'Lunch',
                        start: new Date(y, m, d, 12, 0),
                        end: new Date(y, m, d, 14, 0),
                        allDay: false
                    },
                    {
                        title: 'Birthday Party',
                        start: new Date(y, m, d + 1, 19, 0),
                        end: new Date(y, m, d + 1, 22, 30),
                        allDay: false
                    },
                    {
                        title: 'Click for Google',
                        start: new Date(y, m, 28),
                        end: new Date(y, m, 29),
                        url: 'http://google.com/'
                    }
                ]
            });

        });
    </script>
@endpush
<div>
    <livewire:component.page-heading title_main="Calendar messenger Booking" breadcrumb_title="Messenger"
        breadcrumb_page="calendar messenger Booking" />

    <div class="wrapper wrapper-content animated fadeInRight"> <!-- Body-->


        <div class="col-lg-12">
            <div class="ibox ">

                <div class="ibox-content">
                    <div id="calendar"></div>
                </div>
            </div>
        </div>

    </div>
</div>
