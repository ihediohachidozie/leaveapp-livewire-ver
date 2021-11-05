<?php

namespace App\Http\Livewire;

use App\Models\Leave;
use Livewire\Component;
use App\Models\Public_Holiday;

class OffDuty extends Component
{
    public $users = array();
            
    /**
     * the leaveapp resume date
     * function.
     *
     * @return void
     */
    public function resumeDate($startdate, $days)
    {

        $publicHoliday = Public_Holiday::where('company_id', auth()->user()->company_id)
        ->pluck('date');

        $counter = 1;

        $start_date = date_format(date_create($startdate), "d-m-Y");

        $date = date_create($startdate);

        $date->modify('-1 day');

        $date_array = array();

        foreach ($publicHoliday as $value) 
        {
            array_push($date_array, $value);
        }
       
        while ($counter <= $days + 1) 
         {
            $date->modify('+1 day');

           if($date->format('D') != 'Sat' && $date->format('D') != 'Sun')

            {  
                if(!in_array(date_format($date,"Y-m-d"), $date_array))
                {
                    $counter++;
                    
                }    
            } 
         } 
        return $date > $start_date ? True : False;
    }

    public function whoIsOff()
    {
        $year = date('Y');
        
        $leaves = Leave::whereYear('start_date', $year)->get();
        
        foreach($leaves as $leave)
        {
            if($this->resumeDate($leave->start_date, $leave->days))
            {
                array_push($this->users, $leave->id);
            }
        }
        
        return Leave::whereIn('id', $this->users)->get('user_id');
    }

    public function render()
    {
       // dd($this->whoIsOff());
        return view('livewire.off-duty',[
            'data' => $this->whoIsOff()
        ]);
    }
}
