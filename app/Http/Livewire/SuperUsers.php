<?php

namespace App\Http\Livewire;

use App\Models\Role;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class SuperUsers extends Component
{
    use WithPagination;
    use AuthorizesRequests;
    public $name;

    public $modalConfirmSuperUserVisible = false;
    public $modalConfirmUserVisible = false;
    public $modelId;
    public $search;
    public $role;
    protected $queryString = ['search'];

    /**
     * The livewire mount function
     *
     * @return void
     */
    public function mount(Role $role)
    {
        $this->role = $role;
        # Reset pagination after reloading the page.

        $this->resetPage();
    }

    public function userStatus()
    {
        return array('Disabled', 'Enabled');
    }
        /**
     * Reset all the variables
     * to null.
     *
     * @return void
     */
    public function resetVals()
    {
        $this->name = $this->modelId = null;
    }

    /**
     * Shows the form modal
     * in update mode. 
     *
     * @param  mixed $id
     * @return void
     */
    public function userShowModal($id)
    {
        $this->resetVals();
        $this->modelId = $id;
        $this->modalConfirmUserVisible = true;
        $this->loadModel();
    }
    /**
     * Shows the form modal
     * in update mode. 
     *
     * @param  mixed $id
     * @return void
     */
    public function superSuperShowModal($id)
    {
        $this->resetVals();
        $this->modelId = $id;
        $this->modalConfirmSuperUserVisible = true;
        $this->loadModel();
    }
    /**
     * The load model data
     * of this component.
     *
     * @return void
     */
    public function loadModel()
    {
        $data = User::find($this->modelId);
        $this->name = $data->firstname . ' '. $data->lastname;

    }

    /**
     * The upgrade user 
     * function
     *
     * @return void
     */
    public function upgradeUser()
    {
       
       User::find($this->modelId)->update([
           'role_id' => 2
       ]);
        $this->modalConfirmSuperUserVisible = false;

 
    }

    /**
     * The downgrade user 
     * function
     *
     * @return void
     */
    public function downgradeUser()
    {
       
       User::find($this->modelId)->update([
           'role_id' => 3
       ]);
        $this->modalConfirmUserVisible = false;


    }

    /**
     * The read function.
     *
     * @return void
     */
    public function read()
    {
        return User::where([['firstname', 'LIKE', '%'.$this->search.'%'], ['id', '<>', 1]])
        ->orWhere([['lastname', 'LIKE', '%'.$this->search.'%'], ['id', '<>', 1]])
        ->paginate(20);
    }


    
    public function render()
    {
        $this->authorize('view', $this->role);
        
        return view('livewire.super-users',[
            'data' => $this->read()
        ]);
    }
}
