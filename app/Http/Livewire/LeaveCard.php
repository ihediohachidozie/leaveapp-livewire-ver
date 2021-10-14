<?php

namespace App\Http\Livewire;

use App\Models\User;
use App\Models\Leave;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Validation\Rule;


class LeaveCard extends Component
{
    use WithPagination;
    public $start_date;
    public $days_applied;
    public $year;
    public $leave_type;
    public $duty_reliever;
    public $approval_id;
    public $allowance;
    public $modalFormVisible = false;
    public $modalConfirmDeleteVisible = false;
    public $modelId;
    public $leaveType = ['Annual', 'Casual', 'Maternity', 'Paternity', 'Study', 'Sick', 'Sabbatical', 'Examination'];
    public $status = ['Open', 'Pending', 'Rejected', 'Approved'];
    /**
     * The livewire mount function
     *
     * @return void
     */
    public function mount()
    {
        # Reset pagination after reloading the page.
        $this->resetPage();
    }


    /**
     * Reset all the variables
     * to null.
     *
     * @return void
     */
    public function resetVals()
    {
        $this->modelId = $this->start_date = $this->days_applied = $this->year = null;
        $this->leave_type = $this->duty_reliever = $this->approval_id = $this->allowance = null;
    }


    /**
     * Show the form modal
     * of the create function.
     *
     * @return void
     */
    public function createShowModal()
    {
        $this->resetValidation();
        $this->resetVals();
        $this->modalFormVisible = true;
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
            'days_applied' => 'required',
            'year' => 'required',
            'leave_type' => 'required',
            'duty_reliever' => 'required',
            'approval_id' => 'required',
            'allowance' => 'required'
        ];
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
            'start_date' => $this->start_date,
            'days_applied' => $this->days_applied,
            'outstanding_days' => $this->days_applied,
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
        $this->validate();
        Leave::create($this->modelData());
        $this->modalFormVisible = false;
        $this->resetVals();
    }

    /**
     * Shows the form modal
     * in update mode. 
     *
     * @param  mixed $id
     * @return void
     */
    public function updateShowModal($id)
    {
        $this->resetValidation();
        $this->resetVals();
        $this->modelId = $id;
        $this->modalFormVisible = true;
        $this->loadModel();
    }

    /**
     * The load model data
     * of this component.
     *
     * @return void
     */
    public function loadModel()
    {
        $data = Leave::find($this->modelId);
        $this->start_date = $data->start_date;
        $this->days_applied = $data->days_applied;
        $this->year = $data->year;
        $this->leave_type = $data->leave_type;
        $this->duty_reliever = $data->duty_reliever;
        $this->approval_id = $data->approval_id;
        $this->allowance = $data->allowance;

    }

    /**
     * The update function
     *
     * @return void
     */
    public function update()
    {
        $this->validate();
        Leave::find($this->modelId)->update($this->modelData());
        $this->modalFormVisible = false;
    }

    /**
     * The livewire render function.
     *
     * @return void
     */
    public function render()
    {
        return view('livewire.leave-card',[
            'data' => Leave::where('user_id', auth()->id())->orWhere([['approval_id' => auth()->id()], ['status' => 1]])->paginate(5),
            'users' => User::all(),
            'approvals' => User::where('approval_right', 1)->get(),
            'canApply' => Leave::Where([['user_id', 2],['status', '<', 3]])->count()
            
        ]);
    }  
}
