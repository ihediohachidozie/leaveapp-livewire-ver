<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Public_Holiday;

class ResumptionDate extends Component
{
    public $startdate;
    public $date;
    public $counter;
    public $days;
    public $publicHoliday = [];

        
    /**
     * the leaveapp resume date
     * function.
     *
     * @return void
     */
    public function resumeDate()
    {

        $this->publicHoliday = Public_Holiday::pluck('date');

        $this->counter = 1;

        $this->startdate = date_format(date_create($this->startdate), "d-m-Y");

        $this->date = date_create($this->startdate);

        $this->date->modify('-1 day');

        $date_array = array();

        foreach ($this->publicHoliday as $value) 
        {
            array_push($date_array, $value);
        }
       
        while ($this->counter <= $this->days + 1) 
         {
            $this->date->modify('+1 day');

           if($this->date->format('D') != 'Sat' && $this->date->format('D') != 'Sun')

            {  
                if(!in_array(date_format($this->date,"Y-m-d"), $date_array))
                {
                    $this->counter++;
                    
                }    
            } 
         } 
        return date_format($this->date,"d-m-Y");
    }

        
    /**
     * The render function
     *
     * @return void
     */
    public function render()
    {
        return view('livewire.resumption-date', [
            'resumedate' => $this->resumeDate()
        ]);
    }
}
