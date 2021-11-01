<?php

namespace App\Http\Livewire;

use App\Models\User;
use App\Models\Leave;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class AllLeaveSummary extends Component
{
    use WithPagination;
    use AuthorizesRequests;
    
    public $leave;
    public $search;
    protected $queryString = ['search'];
    
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
    
    /**
     * The get staff leave
     * summary of the component
     *
     * @return void
     */
    public function getStaffLeaveSummary()
    {
        $users = User::where([['firstname', 'LIKE', '%'.$this->search.'%'], ['company_id', auth()->user()->company_id]])
        ->orWhere([['lastname', 'LIKE', '%'.$this->search.'%'], ['company_id', auth()->user()->company_id]])
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
        $this->authorize('view', $this->leave);

        return view('livewire.all-leave-summary', [
            'data' => $this->getStaffLeaveSummary()
        ]); 
    }
}
