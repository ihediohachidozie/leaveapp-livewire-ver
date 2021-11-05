<?php

namespace App\Http\Livewire;

use App\Models\User;
use App\Models\Leave;
use Livewire\Component;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class PaymentRequest extends Component
{

    use AuthorizesRequests;
    
    public $leave;

    /**
     * The livewire mount function
     *
     * @return void
     */
    public function mount(Leave $leave)
    {
        $this->leave = $leave;
    }

    public function checkPaymentRequest()
    {
        $users = User::where('company_id', auth()->user()->company_id)
        ->pluck('id');
        
        return Leave::where([
            ['allowance', 1],  
            ['status', 3]
        ])
        ->WhereIn('user_id', $users)
        ->count();
    }


    public function render()
    {
        $this->authorize('view', $this->leave);

        return view('livewire.payment-request', [
            'data' => $this->checkPaymentRequest()
        ]);
    }
}
