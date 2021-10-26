<?php

namespace App\Http\Livewire;

use App\Models\Leave;
use Livewire\Component;

class PaymentRequest extends Component
{


    public function checkPaymentRequest()
    {
        return Leave::where([
            ['allowance', 1],
            ['status', 3]
        ])->count();
    }


    public function render()
    {
        return view('livewire.payment-request', [
            'data' => $this->checkPaymentRequest()
        ]);
    }
}
