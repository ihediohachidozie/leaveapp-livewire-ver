<?php

namespace App\Http\Livewire;

use App\Mail\LeaveApprovalConfirmation;
use App\Models\Leave;
use Livewire\Component;
use Illuminate\Support\Facades\Mail;

class ApprovalPage extends Component
{
    public $status;
    public $statusResult;
    public $comment;
    public $allowance;
    public $modelId;

    public function mount(Leave $model)
    {
        $this->loadModel($model);
    }

    /**
     * The validation rules.
     *
     * @return void
     */
    public function rules()
    {
        return [
            'status' => 'required',
            'comment' => 'sometimes'
        ];
    }

    public function back()  
    {
        return redirect()->to('/leave-approval');
    }
    public function loadModel($model)
    {
        //dd($model->id);
        $this->status = $model->status;
        $this->modelId = $model->id;
    }

    /**
     * Reset all the variables
     * to null.
     *
     * @return void
     */
    public function resetVals()
    {
        $this->comment = '';
        $this->statusResult = $this->modelId = null;
    }
    
    /**
     * The read Leave
     * function of this component.
     *
     * @return void
     */
    public function readLeave()
    {
        return Leave::where([
            ['approval_id', auth()->id()], 
            ['status', 1]
        ])->paginate(10);
         
    }
    /**
     * check leave allowance
     * payment of this component.
     *
     * @return void
     */
    public function checkPayment()
    {
       $data = Leave::find($this->modelId);

       return Leave::where([
           ['user_id', $data->user_id],
           ['year', $data->year],
           ['allowance', 3]
       ])->count();
        
    }


    /**
     * The data for the model mapped
     * in this component
     *
     * @return void
     */
    public function modelData()
    {

        return [
            'comment' => $this->comment,
            'status' => $this->statusResult
        ];
    }


    /**
     * The leave approval 
     * function
     *
     * @return void
     */
    public function approveLeave()
    {
        $this->validate();
        //dd($this->comment);
        $leave = Leave::find($this->modelId);
        $staff_mail = $leave->user->email;
        $staff_name = $leave->user->firstname .' '. $leave->user->lastname;

        if(intval($this->checkPayment()) == 0)
        {
            Leave::find($this->modelId)->update($this->modelData());

        }else{

            Leave::find($this->modelId)->update([
                'comment' => $this->comment,
                'status' => $this->statusResult,
                'allowance' => 3
            ]);
        }

        $approval_mail = auth()->user()->email;

        Mail::to($staff_mail)->queue(new LeaveApprovalConfirmation($this->statusResult, $this->comment, $staff_name, $approval_mail));

        session()->flash('success', 'Leave application approved successful!');
        $this->back();
    }
    
    /**
     * the render function
     *
     * @return void
     */
    public function render()
    {
        return view('livewire.approval-page');
    }
}
