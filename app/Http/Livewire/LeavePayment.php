<?php

namespace App\Http\Livewire;

use App\Models\Leave;
use Livewire\Component;
use Livewire\WithPagination;

class LeavePayment extends Component
{
    use WithPagination;
    
    public $item;
    public $leaveType = ['Annual', 'Casual', 'Maternity', 'Paternity', 'Study', 'Sick', 'Sabbatical', 'Examination'];
    public $status = ['Open', 'Pending', 'Rejected', 'Approved'];

    protected $listeners = ['payment'];
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
        return Leave::where([
            ['allowance', 1]
        ])->paginate(10);
         
    }

    /**
     * render function
     * of the component
     *
     * @return void
     */
    public function render()
    {
        return view('livewire.leave-payment', [
            'data' => $this->readLeave()
        ]);
    }
}
