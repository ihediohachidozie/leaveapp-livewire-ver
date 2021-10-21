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
     * Go to leave form
     * .
     *
     * @return void
     */
    public function applyLeave()
    {
        return redirect()->to('/apply-leave');
    }

    /**
     * The read Leave
     * function of this component.
     *
     * @return void
     */
    public function readLeave()
    {
        return Leave::where('user_id', auth()->id())->orWhere([['approval_id' => auth()->id()], ['status' => 1]])->paginate(10);
         
    }
    
  
    /**
     * The livewire render function.
     *
     * @return void
     */
    public function render()
    {
        return view('livewire.leave-card', [
            'data' => $this->readLeave(),
 
            'canApply' => Leave::Where([['user_id', auth()->id()],['status', '<', 3]])->count(),
           
        ]);
    }  
}
