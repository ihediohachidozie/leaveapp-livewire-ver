<?php

namespace App\Http\Livewire;

use App\Models\Leave;
use Livewire\Component;

class ApprovalRequest extends Component
{
    

    public function checkApproval()
    {
        return Leave::where([
            ['approval_id', auth()->id()],
            ['status', 1]
        ])->count();
    }

    public function render()
    {
        return view('livewire.approval-request',[
            'data' => $this->checkApproval()
        ]);
    }
}
