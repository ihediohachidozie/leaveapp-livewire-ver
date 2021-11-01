<?php

namespace App\Http\Livewire;

use App\Models\User;
use App\Models\Leave;
use Livewire\Component;
use Livewire\WithPagination; 
use App\Mail\LeaveStatusChanged;
use Illuminate\Support\Facades\Mail;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class OpenLeaveStatus extends Component
{

    use WithPagination;
    use AuthorizesRequests;
    
    public $item;
    public $leaveType = ['Annual', 'Casual', 'Maternity', 'Paternity', 'Study', 'Sick', 'Sabbatical', 'Examination'];
    public $status = ['Open', 'Pending', 'Rejected', 'Approved'];
    public $search;
    protected $queryString = ['search'];
    public $leave;

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
     * The read Leave
     * function of this component.
     *
     * @return void
     */
    public function readLeave()
    {
        //$search = '%'.$this->search.'%';
        $users = User::where([['firstname', 'LIKE', '%'.$this->search.'%'], ['company_id', auth()->user()->company_id]])
        ->orWhere([['lastname', 'LIKE', '%'.$this->search.'%'], ['company_id', auth()->user()->company_id]])
        ->pluck('id');

        return Leave::WhereIn('user_id', $users)        
        ->where('status', 3)
        ->orderBy('id', 'desc')
        ->paginate(10);

    }       
    
            
    /**
     * checkOpenStatus
     *
     * @param  mixed $id
     * @return void
     */
    public function checkOpenStatus($id)
    {
        $data = Leave::find($id);

        return Leave::where([
            ['user_id', $data->user_id],
            ['status', '<>', 3]
        ])->count();
    }
    
    /**
     * checkLastLeave
     *
     * @param  mixed $id
     * @return void
     */
    public function checkLastLeave($id)
    {
        $data = Leave::find($id);

        $this->leave = Leave::where([
            ['user_id', $data->user_id],
            ['year', $data->year],
            ['status', 3]
        ])->orderBy('id', 'desc')
        ->first();

        return ($this->leave->id == $id) ? true : false;
    }
    

    /**
     * The open status
     * function
     *
     * @param  mixed $item
     * @return void
     */
    public function openStatus($item)
    {
      //  dd($item);
        $this->item = $item;

        if($this->checkOpenStatus($item) == 0)
        {
            if($this->checkLastLeave($item))
            {
                Leave::find($this->item)->update([
                    'status' => 0
                ]);
                session()->flash('message', 'Leave application successfully opened.');

                $superuser = auth()->user()->email;

                Mail::to($this->leave->user->email)->queue(new LeaveStatusChanged($this->leave, $superuser));

            }else{
                session()->flash('message', 'Only the last leave application for a particular can be opened.');
                
            }

        }else{
            session()->flash('message', 'The staff has either an open or rejected leave application.');
           
        }
        
       

    }



    public function render()
    {
        $this->authorize('view', $this->leave);

        return view('livewire.open-leave-status', [
            'data' => $this->readLeave()
        ]);
    }
}
