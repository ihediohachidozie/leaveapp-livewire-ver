<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;

class StaffLeaveSummary extends Component
{

    use WithPagination;
    
    /**
     * The get staff leave
     * summary of the component
     *
     * @return void
     */
    public function getStaffLeaveSummary()
    {

        return DB::table('leaves')
        ->select('year', DB::raw('sum(days_applied) as days'), DB::raw('min(outstanding_days) as outstanding'))
        ->where([['user_id', auth()->id()], ['status', 3]])
        ->groupBy('year')
        ->paginate(80);
    }

    public function render()
    {
        return view('livewire.staff-leave-summary', [
            'data' => $this->getStaffLeaveSummary()
        ]);
    }
}
