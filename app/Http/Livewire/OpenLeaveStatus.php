<?php

namespace App\Http\Livewire;

use App\Models\User;
use App\Models\Leave;
use Livewire\Component;
use Livewire\WithPagination; 

class OpenLeaveStatus extends Component
{

    use WithPagination;
    public $item;
    public $leaveType = ['Annual', 'Casual', 'Maternity', 'Paternity', 'Study', 'Sick', 'Sabbatical', 'Examination'];
    public $status = ['Open', 'Pending', 'Rejected', 'Approved'];
    public $search;
    protected $queryString = ['search'];

    /**
     * The livewire mount function
     *
     * @return void
     */
    public function mount()
    {
        # $this->search = $string;
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
        $users = User::where('firstname', 'LIKE', '%'.$this->search.'%')
        ->orWhere('lastname', 'LIKE', '%'.$this->search.'%')
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
               

            }else{
                session()->flash('message', 'Only the last leave application for a particular can be opened.');
                
            }

        }else{
            session()->flash('message', 'The staff has either an open or rejected leave application.');
           
        }
        
       

    }



    public function render()
    {
                
        return view('livewire.open-leave-status', [
            'data' => $this->readLeave()
        ]);
    }
}
