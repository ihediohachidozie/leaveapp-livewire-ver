<?php

namespace App\Http\Livewire;

use Livewire\Component;


class ApprovalTable extends Component
{
    public $item;
    public $leaveType = ['Annual', 'Casual', 'Maternity', 'Paternity', 'Study', 'Sick', 'Sabbatical', 'Examination'];
    public $status = ['Open', 'Pending', 'Rejected', 'Approved'];
    
    public function render()
    {
        return view('livewire.approval-table');
    }
}
