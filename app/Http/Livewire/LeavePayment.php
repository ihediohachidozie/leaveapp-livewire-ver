<?php

namespace App\Http\Livewire;

use App\Models\User;
use App\Models\Leave;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class LeavePayment extends Component
{
    use WithPagination;
    use AuthorizesRequests;
    
    public $leave;
    public $item;
    public $leaveType = ['Annual', 'Casual', 'Maternity', 'Paternity', 'Study', 'Sick', 'Sabbatical', 'Examination'];
    public $status = ['Open', 'Pending', 'Rejected', 'Approved'];

    protected $listeners = ['payment'];
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

    public function payment($item)
    {
        //dd($item);
        $this->item = $item;

        Leave::find($this->item)->update([
            'allowance' => 3
        ]);
        session()->flash('message', 'Leave allowance successfully paid.');
        # code...
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
        

        return Leave::where('allowance', 1)
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
        
        return view('livewire.leave-payment', [
            'data' => $this->readLeave()
        ]);
    } 
}
