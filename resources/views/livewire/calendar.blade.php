<div>
    <div id='calendar-container' wire:ignore>
        <div id='calendar'></div>
    </div>
</div>

<!-- Begin: Modal Confirmation -->
<div wire:ignore.self class="modal fade" id="calendarInfoModal" tabindex="-1" role="dialog" aria-labelledby="calendarInfoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-primary modal-xl" role="document">
        <form autocomplete="off">
            <div class="modal-content">
                <div class="modal-header">

                    <h5 class="modal-title ">Agenda Details </h5>
                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <span class="svg-icon svg-icon-2x">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="black"></rect>
                                <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="black"></rect>
                            </svg>
                        </span>
                    </div>
                    <!--end::Close-->
                </div>
                <div class="modal-body">
                    <form>
                        <div class="row">
                            <div class="col-md-9 mb-3">
                                <label class="form-label">Title</label>
                                <input id="agendaTitle" type="text" class="form-control form-control-solid" disabled>
                                <input id="agendaDetailID" type="hidden" class="form-control form-control-solid" disabled>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Item No.</label>
                                <input id="agendaItemNo" type="text" class="form-control form-control-solid" disabled>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3 mb-2">
                                <label class="form-label">Target Start Date</label>
                                <input id="agendaTargetStart" class="form-control form-control-solid" disabled>
                            </div>
                            <div class="col-md-3 mb-2">
                                <label class="form-label">Target End Date</label>
                                <input id="agendaTargetEnd" class="form-control form-control-solid" disabled>
                            </div>
                            <div class="col-md-3 mb-2">
                                <label class="form-label">PR No.</label>
                                <input id="agendaPRNo" class="form-control form-control-solid" disabled>
                            </div>
                            <div class="col-md-3 mb-2">
                                <label class="form-label">Status</label>
                                <input id="agendaStatus" class="form-control form-control-solid" disabled>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Details</label>
                                <textarea id="agendaDetails" type="text" rows="4" placeholder="Please enter the Details." class="form-control form-control-solid" disabled></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Remarks</label>
                                <textarea id="agendaRemarks"  type="text" rows="4" placeholder="Please enter remarks" class="form-control form-control-solid" disabled></textarea>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary close-modal px-5" wire:click="editAgendaDetails" title="Edit Record"> Edit</button>
                    {{--<button class="btn btn-primary close-modal px-5" wire:click="updateDetails({{$agendaDetailID ?? '' }})" title="Edit Record"  data-bs-toggle="modal" data-bs-target="#formUpdateModal"> Edit</button>--}}
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- End: Modal Confirmation -->

@push('scripts')
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.3.1/main.min.css' rel='stylesheet' />
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.3.1/main.min.js'></script>

    <script>
        document.addEventListener('livewire:load', function() {

            var Calendar = FullCalendar.Calendar;
            var Draggable = FullCalendar.Draggable;
            var calendarEl = document.getElementById('calendar');
            var checkbox = document.getElementById('drop-remove');
            var data = @this.events;
            // console.log(data);

            var todayDate = moment().startOf('day');
            var YM = todayDate.format('YYYY-MM');
            var YESTERDAY = todayDate.clone().subtract(1, 'day').format('YYYY-MM-DD');
            var TODAY = todayDate.format('YYYY-MM-DD');
            var TOMORROW = todayDate.clone().add(1, 'day').format('YYYY-MM-DD');

            var calendar = new Calendar(calendarEl, {
                events: JSON.parse(data),

                eventClick(info) {
                    if (info.event.title) {
                        // console.log( JSON.stringify(info.event));
                        $( "#agendaTitle" ).val( info.event.title );
                        $( "#agendaDetailID" ).val( info.event.id );
                        // $( ".agendaStart" ).text( moment(info.event.start,'DD/MM/YYYY HH:mm').format('MMM DD, YYYY') );
                        $( "#agendaTargetStart" ).val( moment(info.event.extendedProps.target_start_date,'YYYY-MM-DD HH:mm').format('MMM DD, YYYY') );
                        $( "#agendaTargetEnd" ).val( moment(info.event.extendedProps.target_end_date,'YYYY-MM-DD HH:mm').format('MMM DD, YYYY') );
                        $( "#agendaDetails" ).val( info.event.extendedProps.details );
                        $( "#agendaRemarks" ).val( info.event.extendedProps.remarks );
                        $( "#agendaPRNo" ).val( info.event.extendedProps.pr_no );
                        $( "#agendaStatus" ).val( info.event.extendedProps.status );
                        $( "#agendaItemNo" ).val( info.event.extendedProps.item_no );
                        // console.log('asdasdasd: ' + info.event.details);
                        // $("#calendarInfoModal").modal('show');
                        livewire.emit('agendaDetailsModal',info.event.id);
                        //updateDetails(info.event.id);
                        //wire:click="updateDetails(info.event.id)"
                        //window.open("http://localhost:8000/pims/subclassifications", "_blank");
                        // window.open("/vtt/showAgendaDetails/"+info.event.id, "_blank");
                        return false;
                    }
                },
                dateClick(info)  {
                    var title = prompt('Enter Event Title');
                    var date = new Date(info.dateStr + 'T00:00:00');
                    if(title != null && title != ''){
                        calendar.addEvent({
                            title: title,
                            start: date,
                            allDay: true
                        });
                        var eventAdd = {title: title,start: date};
                            @this.addevent(eventAdd);
                        alert('Great. Now, update database...');
                    }else{
                        alert('Event Title Is Required');
                    }
                },

                /*header:{
                    left:'prev,next today',
                    center:'title',
                    right:'month,agendaWeek,agendaDay'
                },
                selectHelper: true,
                height: 800,
                contentHeight: 780,
                navLinks: true,
                aspectRatio: 3,
                defaultView: 'dayGridMonth',
                defaultDate: TODAY,
                eventLimit: true,*/

                editable: true,
                selectable: true,
                displayEventTime: true,
                droppable: true, // this allows things to be dropped onto the calendar
                drop: function(info) {
                    // is the "remove after drop" checkbox checked?
                    if (checkbox.checked) {
                        // if so, remove the element from the "Draggable Events" list
                        info.draggedEl.parentNode.removeChild(info.draggedEl);
                    }
                },
                eventDrop: info => @this.eventDrop(info.event, info.oldEvent),
                loading: function(isLoading) {
                if (!isLoading) {
                    // Reset custom events
                    this.getEvents().forEach(function(e){
                        if (e.source === null) {
                            e.remove();
                        }
                    });
                }
            }
        });
            calendar.render();
            @this.on(`refreshCalendar`, () => {
                calendar.refetchEvents()
        });
        });

        $(document).ready(function () {
            window.addEventListener('showAgendaModal', event => {
                $("#calendarInfoModal").modal('show');
            });
        });

    </script>

@endpush
