<?php

namespace App\Http\Livewire;

use App\Models\User;
use App\Models\Leave;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;

class AllLeaveSummary extends Component
{
    use WithPagination;

    public $search;
    protected $queryString = ['search'];
    
    /**
     * The get staff leave
     * summary of the component
     *
     * @return void
     */
    public function getStaffLeaveSummary()
    {
        $users = User::where('firstname', 'LIKE', '%'.$this->search.'%')
        ->orWhere('lastname', 'LIKE', '%'.$this->search.'%')
        ->pluck('id');

        return Leave::select('user_id', 'year', DB::raw('sum(days_applied) as days'), DB::raw('min(outstanding_days) as outstanding'))
        ->where('status', 3)
        ->WhereIn('user_id', $users)
        ->groupBy('user_id', 'year')
        ->paginate(80);
    }
        
    /**
     * render function
     *
     * @return void
     */
    public function render()
    {
        return view('livewire.all-leave-summary', [
            'data' => $this->getStaffLeaveSummary()
        ]); 
    }
}
