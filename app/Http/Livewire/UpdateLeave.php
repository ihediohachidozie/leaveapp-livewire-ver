<?php

namespace App\Http\Livewire;

use App\Models\User;
use App\Models\Leave;
use Livewire\Component;

class UpdateLeave extends Component
{

    public $start_date;
    public $days_applied;
    public $year;
    public $leave_type;
    public $duty_reliever;
    public $approval_id;
    public $allowance;

    public $statusCheck;
    public $modelId;
    public $outstandingDays = 0;

    public $leaveType = ['Annual', 'Casual', 'Maternity', 'Paternity', 'Study', 'Sick', 'Sabbatical', 'Examination'];
    public $status = ['Open', 'Pending', 'Rejected', 'Approved'];


    public function mount(Leave $model)
    {
        $this->loadModel($model);
    }

    /**
     * Reset all the variables
     * to null.
     *
     * @return void
     */
    public function resetVals()
    {
        $this->modelId = $this->start_date = $this->days_applied = $this->year = $this->outstandingDays = null;
        $this->leave_type = $this->duty_reliever = $this->approval_id = $this->allowance = null;
    }

    /**
     * The validation rules.
     *
     * @return void
     */
    public function rules()
    {

        return [
            'start_date' => 'required',
            'days_applied' => 'required|numeric',
            'year' => 'required',
            'leave_type' => 'required',
            'duty_reliever' => 'required',
            'approval_id' => 'required',
            'allowance' => 'required'
        ];
    }

    /**
     * check Same Date
     * function
     *
     * @return void
     */
    public function checkSameDate()
    {
        return Leave::where([['user_id', auth()->id()], ['start_date', $this->start_date]])->count();
    }

    /**
     * Get the user 
     * approved Days
     *
     * @return void
     */
    public function approvedDays()
    {
        return auth()->user()->category->days;

    }
    
    /**
     * The getOutstandingDays
     * function of this 
     * component
     *
     * @return void
     */
    public function getOutstandingDays()
    {
        return Leave::where([
            ['user_id', auth()->id()],
            ['year', $this->year],
            ['status', 3]
            ])->orderBy('id', 'desc')
            ->pluck('outstanding_days')
            ->first();      

    }


    /**
     * back function
     * to leave list
     *
     * @return void
     */
    public function back()
    {
        return redirect()->to('/leave');
    }


    /**
     * The data for the model mapped
     * in this component
     *
     * @return void
     */
    public function modelData($outstandingDays)
    {
        return [
            'start_date' => $this->start_date,
            'days_applied' => $this->days_applied,
            'outstanding_days' => $outstandingDays,
            'year' => $this->year,
            'leave_type' => $this->leave_type,
            'duty_reliever' => $this->duty_reliever,
            'user_id' => auth()->id(),
            'approval_id' => $this->approval_id,
            'allowance' => $this->allowance,
            'status' => 1
        ];
    }



    /**
     * The load model data
     * of this component.
     *
     * @return void
     */
    public function loadModel($model)
    {  

        $this->start_date = $model->start_date;
        $this->days_applied = $model->days_applied;
        $this->year = $model->year;
        $this->leave_type = $model->leave_type;
        $this->duty_reliever = $model->duty_reliever;
        $this->approval_id = $model->approval_id;
        $this->allowance = $model->allowance;
        $this->modelId = $model->id;
        $this->statusCheck = $model->status;

    }


    /**
     * The update function
     *
     * @return void
     */
    public function update()
    {
        if(intval($this->approvedDays()) >= $this->days_applied)
        {
            if(intval($this->getOutstandingDays()) == 0)
            {
                $this->outstandingDays = intval($this->approvedDays()) - $this->days_applied;

                $this->updateSub();

            }
            elseif(intval($this->getOutstandingDays()) >= $this->days_applied)
            {
                $this->outstandingDays = intval($this->getOutstandingDays()) - $this->days_applied;

                $this->updateSub();

            }else{

                session()->flash('session', 'Days applied is more than outstanding days for the year');
            }
        }
        else{

            session()->flash('session', 'Value is greater than approved days');
        }

    }

    
    /**
     * The update Sub
     * funtion of this
     * component
     *
     * @param  mixed $var
     * @return void
     */
    public function updateSub()
    {
        if($this->approvedDays() >= $this->days_applied)
        {
            $this->validate();
           
            Leave::find($this->modelId)->update($this->modelData($this->outstandingDays));
            $this->statusCheck = 1;
            session()->flash('success', 'Leave application updated successful!');

        
        }
        else{

            session()->flash('session', 'Value is greater than approved days');
        }
    }
    
    /**
     * render function
     *
     * @return void
     */
    public function render()
    {
        return view('livewire.update-leave', [
            'users' => User::where('id', '<>', auth()->id())->get(),
            'approvals' => User::where('approval_right', 1)->get()
        ]);
    }
}
