<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;

class GetName extends Component
{
    public $userid;
    
  
    public function retrieveName()
    {
        return User::find($this->userid);
    }

    public function render()
    {
        return view('livewire.get-name',[
            'name' => $this->retrieveName()->name
        ]);
    }
}
