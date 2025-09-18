<?php
namespace App\Http\Livewire;
use Livewire\Component;
use App\Models\Vtt\AgendaDetail;

class Calendar extends Component
{
    public $events = '';
    public $agendaDetailID;

    protected $listeners = [
        'agendaDetailsModal',
    ];

    public function getevent()
    {
        $events = AgendaDetail::select('id','title','start','details','remarks','target_start_date', 'target_end_date', 'status', 'pr_no','item_no')->get();
        return  json_encode($events);
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function addevent($event)
    {
        $input['title'] = $event['title'];
        $input['start'] = $event['start'];
        $input['target_start_date'] = $event['start'];
        AgendaDetail::create($input);
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function eventDrop($event, $oldEvent)
    {
        $eventdata = AgendaDetail::find($event['id']);
        $eventdata->start = $event['start'];
        $eventdata->target_start_date = date("Y-m-d", strtotime($event['start'])) .' '. date("H:i:s", strtotime($event['start']));

        $eventdata->save();
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function render()
    {
        $events = AgendaDetail::select('id','title','start','details','remarks','target_start_date', 'target_end_date', 'status', 'pr_no','item_no')->get();
        $this->events = json_encode($events);

        return view('livewire.calendar');
    }

    public function agendaDetailsModal($id){
        if(!empty($id)){
            $AgendaDetail = AgendaDetail::find($id);
            $this->agendaDetailID = $AgendaDetail->id;
            $this->emit('calendarUpdateDetails', $this->agendaDetailID);
//            $this->dispatchBrowserEvent('showAgendaModal', ['agenda' => $AgendaDetail]);
        }else{
            $this->agendaDetailID = '';
            return false;
        }
    }

    public function editAgendaDetails(){
        if(!empty($this->agendaDetailID)){
            $this->emit('calendarUpdateDetails', $this->agendaDetailID);
        }else{
            return false;
        }
    }
}
