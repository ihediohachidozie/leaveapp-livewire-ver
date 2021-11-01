<?php

namespace App\Http\Livewire;

use App\Mail\LeaveApprovalRequest;
use App\Models\User;
use App\Models\Leave;
use Livewire\Component;
use Illuminate\Support\Facades\Mail;



class ApplyCard extends Component
{

    public $user_approved_days;
    public $start_date;
    public $days_applied;
    public $year;
    public $leave_type;
    public $duty_reliever;
    public $approval_id;
    public $allowance;
    
    public $outstandingDays = 0;
    public $daysUtilized = 0;
    public $leaveType = ['Annual', 'Casual', 'Maternity', 'Paternity', 'Study', 'Sick', 'Sabbatical', 'Examination'];
    public $status = ['Open', 'Pending', 'Rejected', 'Approved'];

        
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
     * Reset all the variables
     * to null.
     *
     * @return void
     */
    public function resetVals()
    {
        $this->start_date = $this->days_applied = $this->year = $this->outstandingDays = null;
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
     * The create function.
     *
     * @return void
     */
    public function create()
    {
        
        if(intval($this->approvedDays()) >= $this->days_applied)
        {
            if(intval($this->getOutstandingDays()) == 0)
            {
                $this->outstandingDays = intval($this->approvedDays()) - $this->days_applied;
               
                $this->createSub($this->approval_id);

            }
            elseif(intval($this->getOutstandingDays()) >= $this->days_applied)
            {
                $this->outstandingDays = intval($this->getOutstandingDays()) - $this->days_applied;

                
                $this->createSub($this->approval_id);

            }else{

                session()->flash('session', 'You have exceeded your outstanding days for the year');
            }
        }
        else{

            session()->flash('session', 'Value entered is greater than the official approved days');
        }

    }

    
    /**
     * The create Sub
     * function of this
     * component
     *
     * @return void
     */
    public function createSub($id)
    {
        if(intval($this->checkSameDate()) == 0 )
        {
            $this->validate();
            Leave::create($this->modelData($this->outstandingDays ));
            $this->resetVals();

            //dd($id);
            $approval_email = User::find($id);

            session()->flash('success', 'Leave application successful!');
            // send mail to approval id
            Mail::to($approval_email->email)->queue(new LeaveApprovalRequest());
            $this->back();
        }
        else{

            session()->flash('session', 'Start date already exit');
        }
    }

    /**
     * the getUsers function
     *
     * @return void
     */
    public function getUsers()
    {
        return User::whereNotIn('id', [1, auth()->id()])
            ->where('company_id', auth()->user()->company_id) 
            ->get();
    }
    
    /**
     * getApprovals function
     *
     * @return void
     */
    public function getApprovals()
    {
        return User::whereNotIn('id', [1, auth()->id()])
            ->where([
                ['approval_right', 1],
                ['company_id', auth()->user()->company_id]
                ])->get();
    }

    /**
     * render function
     *
     * @return void
     */
    public function render()
    {
        //dd($this->getApprovals()->count());

        return view('livewire.apply-card', [

            'users' => $this->getUsers(),

            'approvals' => $this->getApprovals(),
        ]);  
    }
}
