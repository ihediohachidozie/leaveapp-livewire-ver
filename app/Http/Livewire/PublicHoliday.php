<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Public_Holiday;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class PublicHoliday extends Component
{

    use WithPagination;
    use AuthorizesRequests;

    public $description;
    public $date;
    public $modalFormVisible = false;
    public $modalConfirmDeleteVisible = false;
    public $modelId;
    public $public_holiday;



    /**
     * The livewire mount function
     *
     * @return void
     */
    public function mount(Public_Holiday $public_holiday)
    {
        $this->public_holiday = $public_holiday;
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
    public function updatedDescription($value)
    {
      //  $transform = strtolower($value);
        $this->description = strtolower(trim($value));
    }

    /**
     * The validation rules.
     *
     * @return void
     */
    public function rules()
    {
        return [
            'description' => 'required',
            'date' => ['required', Rule::unique('public__holidays', 'date')->ignore($this->modelId)],
                
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
        Public_Holiday::create($this->modelData());
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
        return Public_Holiday::where('company_id', auth()->user()->company_id)
        ->paginate(10);
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
        $data = Public_Holiday::find($this->modelId);
        $this->description = $data->description;
        $this->date = $data->date;
    }

    
    /**
     * The update function
     *
     * @return void
     */
    public function update()
    {
        $this->validate();
        Public_Holiday::find($this->modelId)->update($this->modelData());
        $this->modalFormVisible = false;
    }
    
    /**
     * The delete function
     *
     * @return void
     */
    public function delete()
    {
        Public_Holiday::destroy($this->modelId);
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
            'description' => $this->description,
            'date' => $this->date,
            'company_id' => auth()->user()->company_id
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
        $this->description = $this->date = $this->modelId = null;
    }

    /**
     * The livewire render function.
     *
     * @return void
     */
    public function render()
    {
        $this->authorize('view', $this->public_holiday);

        return view('livewire.public-holiday', [
            'data' => $this->read(),
        ]);
    }

}
