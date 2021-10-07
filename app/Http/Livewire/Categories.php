<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Validation\Rule;
use App\Models\Category;
use Livewire\WithPagination;

class Categories extends Component
{
    use WithPagination;
    public $name;
    public $days;
    public $modalFormVisible = false;
    public $modalConfirmDeleteVisible = false;
    public $modelId;

            
    /**
     * The livewire mount function
     *
     * @return void
     */
    public function mount()
    {
        # Reset pagination after reloading the page.
        $this->resetPage();
    }
    
    /**
     * Change name value 
     * to lower case.
     *
     * @param  mixed $value
     * @return void
     */
    public function updatedName($value)
    {
      //  $transform = strtolower($value);
        $this->name = strtolower(trim($value));
    }

    /**
     * The validation rules.
     *
     * @return void
     */
    public function rules()
    {
        return [
            'name' => ['required', Rule::unique('categories', 'name')->ignore($this->modelId)],
            'days' => ['required', 'numeric', 'min:20', 'max:30']
     
        ];
    }
    
    /**
     * The create function.
     *
     * @return void
     */
    public function create()
    {
        $this->validate();
        Category::create($this->modelData());
        $this->modalFormVisible = false;
        $this->resetVals();
    }
        
    /**
     * The read function.
     *
     * @return void
     */
    public function read()
    {
        return Category::paginate(5);
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
     * Show the delete confirmation modal.
     *
     * @param  mixed $id
     * @return void
     */
    public function deleteShowModal($id)
    {
        $this->modelId = $id;
        $this->modalConfirmDeleteVisible = true;
    }
    
    /**
     * The load model data
     * of this component.
     *
     * @return void
     */
    public function loadModel()
    {
        $data = Category::find($this->modelId);
        $this->name = $data->name;
        $this->days = $data->days;
    }

    
    /**
     * The update function
     *
     * @return void
     */
    public function update()
    {
        $this->validate();
        Category::find($this->modelId)->update($this->modelData());
        $this->modalFormVisible = false;
    }
    
    /**
     * The delete function
     *
     * @return void
     */
    public function delete()
    {
        Category::destroy($this->modelId);
        $this->modalConfirmDeleteVisible = false;
        $this->resetPage();

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
            'name' => $this->name,
            'days' => $this->days
        ];
    }

    /**
     * Show the form modal
     * of the create function.
     *
     * @return void
     */
    public function createShowModal()
    {
        $this->resetValidation();
        $this->resetVals();
        $this->modalFormVisible = true;
    }
    
    
    /**
     * Reset all the variables
     * to null.
     *
     * @return void
     */
    public function resetVals()
    {
        $this->name = $this->days = $this->modelId = null;
    }

    /**
     * The livewire render function.
     *
     * @return void
     */
    public function render()
    {
        return view('livewire.categories', [
            'data' => $this->read(),
        ]);
    }
}

/* <?php

namespace App\Http\Livewire;

use Livewire\Component;

class Categories extends Component
{
    public function render()
    {
        return view('livewire.categories');
    }
} */
