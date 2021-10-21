<?php

namespace App\Http\Livewire;

use App\Models\User;
use App\Models\Leave;
use Livewire\Component;

class DataTable extends Component
{
    public $item;
    public $leaveType = ['Annual', 'Casual', 'Maternity', 'Paternity', 'Study', 'Sick', 'Sabbatical', 'Examination'];
    public $status = ['Open', 'Pending', 'Rejected', 'Approved'];

    protected $listeners = ['refreshTable' => '$refresh'];
        
    /**
     * The read Leave
     * function of this component.
     *
     * @return void
     */
    public function readLeave()
    {
        return Leave::where('user_id', auth()->id())->orWhere([['approval_id' => auth()->id()], ['status' => 1]])->paginate(10);
         
        # code...
    }

        
    /**
     * The render function
     *
     * @return void
     */
    public function render()
    {
        return view('livewire.data-table', [
            'data' => $this->readLeave(),
            'users' => User::where('id', '<>', auth()->id())->get(),
            'approvals' => User::where('approval_right', 1)->get(),
            'canApply' => Leave::Where([['user_id', auth()->id()],['status', '<', 3]])->count(),
        ]);
    }
}
