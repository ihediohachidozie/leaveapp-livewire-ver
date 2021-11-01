<?php

namespace App\Http\Livewire;

use App\Models\User;
use App\Models\Leave;
use Livewire\Component;

use Livewire\WithPagination;
use function PHPUnit\Framework\isNull;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class LeaveStatus extends Component
{
    use WithPagination;
    use AuthorizesRequests;
    
    public $leave;
    
    public $leaveType = ['Annual', 'Casual', 'Maternity', 'Paternity', 'Study', 'Sick', 'Sabbatical', 'Examination'];
    public $status = ['Open', 'Pending', 'Rejected', 'Approved'];

      


    /**
     * The livewire mount function
     *
     * @return void
     */
    public function mount(Leave $leave)
    {
        $this->leave = $leave;
        
        # Reset pagination after reloading the page.
        $this->resetPage();
    }
    
        
    /**
     * The read Leave
     * function of this component.
     *
     * @return void
     */
    public function readLeave()
    {
        $users = User::where('company_id', auth()->user()->company_id)->pluck('id');
        
        return Leave::where('status', 3)
        ->whereIn('user_id', $users)
        ->orderBy('id', 'desc')
        ->paginate(10);

    }    
    

    /**
     * render function
     * of the component
     *
     * @return void
     */
    public function render()
    {
        $this->authorize('view', $this->leave);

        return view('livewire.leave-status', [
            'data' => $this->readLeave()
        ]);
    }
}
