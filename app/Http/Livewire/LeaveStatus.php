<?php

namespace App\Http\Livewire;

use App\Models\Leave;
use Livewire\Component;
use Livewire\WithPagination;

use function PHPUnit\Framework\isNull;

class LeaveStatus extends Component
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
     * The read Leave
     * function of this component.
     *
     * @return void
     */
    public function readLeave()
    {
        return Leave::where('status', 3)
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
        return view('livewire.leave-status', [
            'data' => $this->readLeave()
        ]);
    }
}
