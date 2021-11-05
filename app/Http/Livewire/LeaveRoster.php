<?php

namespace App\Http\Livewire;

use App\Models\User;
use App\Models\Roster;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Validation\Rule;

class LeaveRoster extends Component
{
    use WithPagination;

    
    public $commencement_date;
    public $status = ['Pending Approval', 'Rejected', 'Approved'];
    public $modalFormVisible = false;
    public $modalConfirmApproveVisible = false;
    public $modelId;
    
 
    /**
     * Reset all the variables
     * to null.
     *
     * @return void
     */
    public function resetVals()
    {
        $this->commencement_date = $this->modelId = null;
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
     * the getUsers within the 
     * same department & company
     * function
     *
     * @return void
     */
    public function getUsers()
    {
        $year = date('Y');

        $users = User::where([
            ['department_id', auth()->user()->department_id], 
            ['company_id', auth()->user()->company_id]
        ])->pluck('id');

        return Roster::whereIn('user_id', $users)
        ->whereYear('commencement_date', $year)
        ->paginate(10);
    }

    public function checkDate()
    {
        $users = User::where([
            ['department_id', auth()->user()->department_id], 
            ['company_id', auth()->user()->company_id]
        ])->pluck('id');

        return Roster::whereIn('user_id', $users)
        ->whereDate('commencement_date', $this->commencement_date)
        ->count();
    }

    
    /**
     * The validation rules.
     *
     * @return void
     */
    public function rules()
    {
        //dd($this->com_date);
        return [
            'commencement_date' => ['required']
        ];
    }

    /**
     * The create function.
     *
     * @return void
     */
    public function create()
    {
        //$this->validate();
        if($this->checkDate() == 0)
        {
            Roster::create($this->modelData());
            $this->modalFormVisible = false;
            $this->resetVals();
        }
        else{
            session()->flash('session', 'Date exists. Two staffs can not start leave on same day.');
        }
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
            'user_id' => auth()->id(),
            'commencement_date' => $this->commencement_date
        ];
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
        $data = Roster::find($this->modelId);
        $this->commencement_date = $data->commencement_date;
    }

    
    /**
     * The update function
     *
     * @return void
     */
    public function update()
    {
        $this->validate();

        if($this->checkDate() == 0)
        { 
            Roster::find($this->modelId)->update($this->modelData());
            $this->modalFormVisible = false;
       }
        else{
            session()->flash('session', 'Commencement Date already taken by another user.');
        } 
        
    }
        

    public function checkPending()
    {
        $year = date('Y');

        return Roster::where('user_id', auth()->id())
        ->whereYear('commencement_date', $year)
        ->count();
    }

    
    /**
     * Show the delete confirmation modal.
     *
     * @param  mixed $id
     * @return void
     */
    public function approveShowModal($id)
    {
        $this->modelId = $id;
        $this->modalConfirmApproveVisible = true;
    }

    /**
     * The delete function
     *
     * @return void
     */
    public function approve()
    {
        Roster::find($this->modelId)->update([
            'status' => 2
        ]);
        $this->modalConfirmApproveVisible = false;
        $this->resetPage();

    }    


    /**
     * render function
     *
     * @return void
     */
    public function render()
    {
        return view('livewire.leave-roster', [
            'data' => $this->getUsers(),
            'status' => $this->status,
            'checkRoster' => $this->checkPending()
        ]);
    }
}
