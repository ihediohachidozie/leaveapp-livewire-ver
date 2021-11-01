<?php

namespace App\Http\Livewire;

use App\Mail\UserActivated;
use App\Models\User;
use Livewire\Component;
use App\Models\Category;
use App\Models\Department;
use Livewire\WithPagination;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Mail;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class UsersList extends Component
{
    use WithPagination;
    use AuthorizesRequests;
    
    public $name;
    public $username;
    public $staffid;
    public $companyid;
    public $department_id;
    public $category_id;
    public $status;
    public $approvalRight;
    public $modalFormVisible = false;
    public $modalConfirmDisableVisible = false;
    public $modalConfirmEnableVisible = false;
    public $modelId;
    public $search;
    public $email;
    protected $queryString = ['search'];

    public $model;
    

    public $count = 0;
 
    public function increment()
    {
        $this->count++;
    }

    /**
     * The livewire mount function
     *
     * @return void
     */
    public function mount(User $model)
    {
        $this->model = $model;
        # Reset pagination after reloading the page.
        $this->resetPage();
    }

    public function userStatus()
    {
        return array('Disabled', 'Enabled');
    }
    /**
     * The read function.
     *
     * @return void
     */
    public function read()
    {
        $search = '%'.$this->search.'%';
        return User::where([['firstname', 'LIKE', '%'.$this->search.'%'], ['company_id', auth()->user()->company_id]])
        ->orWhere([['lastname', 'LIKE', '%'.$this->search.'%'], ['company_id', auth()->user()->company_id]])
        ->paginate(10);
    }
    
    /**
     * The read function 
     * for Department.
     *
     * @return void
     */
    public function readDepartment()
    {
        return Department::where('company_id', auth()->user()->company_id)->get();
    }

    public function readCategory()
    {
        return Category::where('company_id', auth()->user()->company_id)->get();
    }
    /**
     * Reset all the variables
     * to null.
     *
     * @return void
     */
    public function resetVals()
    {
        $this->name = $this->modelId = $this->approvalRight = $this->username = $this->staffid = $this->companyid = $this->department_id = $this->category_id = null;
    }

    /**
     * Shows the form modal
     * in update mode. 
     *
     * @param  mixed $id
     * @return void
     */
    public function updateShowModal($id)
    {
        $this->resetValidation();
        $this->resetVals();
        $this->modelId = $id;
        $this->modalFormVisible = true;
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
      //  dd($data);
        $this->name = $data->firstname . ' '. $data->lastname;
        $this->category_id = $data->category_id;
        $this->department_id = $data->department_id;
        $this->approvalRight = $data->approval_right;
        $this->email = $data->email;
    }

    /**
     * The validation rules.
     *
     * @return void
     */
    public function rules()
    {
        return [
            'department_id' => 'required',
            'category_id' => 'required',     
        ];
    }

    /**
     * The data for the model mapped
     * in this component
     *
     * @return void
     */
    public function modelData()
    {
      
        return [
            'department_id' => $this->department_id,
            'category_id' => $this->category_id,
            'approval_right' => $this->approvalRight
        ];
    }

    /**
     * The update function
     *
     * @return void
     */
    public function update()
    {
      
        $this->validate();
        User::find($this->modelId)->update($this->modelData());
        $this->modalFormVisible = false; 
        Mail::to($this->email)->queue(new UserActivated($this->name));
    }

    /**
     * Show the disable confirmation modal.
     *
     * @param  mixed $id
     * @return void
     */
    public function disableShowModal($id)
    {
        $this->modelId = $id;
        $this->modalConfirmDisableVisible = true;
    }

        /**
     * Show the enable confirmation modal.
     *
     * @param  mixed $id
     * @return void
     */
    public function enableShowModal($id)
    {
        $this->modelId = $id;
        $this->modalConfirmEnableVisible = true;
    }

    /**
     * The disable function
     *
     * @return void
     */
    public function disable()
    {
      
       User::find($this->modelId)->update([
           'status' => 0
       ]);

       $this->modalConfirmDisableVisible = false;
       $this->resetPage();
        

    }

    /**
     * The enable function
     *
     * @return void
     */
    public function enable()
    {
       
       User::find($this->modelId)->update([
           'status' => 1
       ]);
        $this->modalConfirmEnableVisible = false;
        $this->resetPage();

    }

    /**
     * The livewire render function.
     *
     * @return void
     */
    public function render()
    {
        $this->authorize('view', $this->model);
        
        return view('livewire.users-list',[
            'data' => $this->read(),
            'dataDep' => $this->readDepartment(),
            'dataCat' => $this->readCategory()
        ]);
      

    }
}
