<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __(strtoupper(Request::route()->getName())) }} 
    </h2>
</x-slot>
<div class="p-6">

    <!-- The Data Table -->
    <div class="flex flex-col">
        <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="py-2 align-middle inline-block w-full sm:px-6 lg:px-8">
                <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                    <table class="w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-700 uppercase tracking-wider">S/N</th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-700 uppercase tracking-wider">name</th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-700 uppercase tracking-wider">username</th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-700 uppercase tracking-wider">staff id</th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-700 uppercase tracking-wider">department</th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-700 uppercase tracking-wider">category</th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-700 uppercase tracking-wider">status</th>

                                <th class="px-6 py-3 bg-gray-50 text-right text-xs leading-4 font-medium text-gray-700 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @if ($data->count())
                                @foreach ($data as $item)
                                    <tr>
                                        <td class="px-6 py-4 text-sm whitespace-no-wrap">{{$item->id}}</td>
                                        <td class="px-6 py-4 text-sm whitespace-no-wrap">{{ strtoupper($item->name)}}</td>
                                        <td class="px-6 py-4 text-sm whitespace-no-wrap">{{ $item->username}}</td>
                                        <td class="px-6 py-4 text-sm whitespace-no-wrap">{{ $item->staff_id}}</td>
                                        <td class="px-6 py-4 text-sm whitespace-no-wrap"> 
                                            @if($item->department_id)
                                                {{ strtoupper($item->department->name)}}
                                            @else
                                                {{'N/A'}}
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-sm whitespace-no-wrap">
                                            @if($item->category_id)
                                                {{ strtoupper($item->category->name)}}
                                            @else
                                                {{'N/A'}}
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-sm whitespace-no-wrap">
                                            @if ($item->status == 0)
                                                {{ strtoupper('disabled') }}
                                            @else
                                                {{ strtoupper('enabled') }}
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-right text-sm">
                                            <x-jet-button wire:click="updateShowModal({{ $item->id }})">
                                                {{ __('Update') }}
                                            </x-jet-button>
                                            @if($item->status == 0)
                                                <x-jet-secondary-button wire:click="enableShowModal({{$item->id}})">
                                                    {{ __('Enable') }}
                                                </x-jet-secondary-button>
                                            @elseif ($item->status == 1)
                                                <x-jet-danger-button wire:click="disableShowModal({{$item->id}})">
                                                    {{ __('Disable') }}
                                                </x-jet-danger-button>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td class="px-6 py-4 text-sm whitespace-no-wrap text-center" colspan ='6'>No Result Found</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                    
                </div>

            </div>

        </div>

    </div>
    {{ $data->links()}}



        <!-- Modal Form -->
        <x-jet-dialog-modal wire:model="modalFormVisible">

        <x-slot name="title">
            {{ __('Edit User') }}   
        </x-slot>

        <x-slot name="content">
            <table class="w-full">
                <tr>
                    <td class="px-2 py-2">
                        <div>
                            <x-jet-label for="name" value="{{ __('Name') }}" />
                            <x-jet-input wire:model.lazy="name" id="name" class="block mt-1 w-full" type="text" disabled/> 
                            @error('name') <span class="error">{{$message}}</span> @enderror
                        </div>
                    </td>
                   
                    <td class="px-2 py-2" >
                        <div>
                            <x-jet-label for="department" value="{{ __('Department') }}" />
                            <select wire:model="department_id" id="department_id" class="block mt-1 w-full rounded-md border-gray-400 shadow-sm opacity-70">
                                <option></option>
                                @foreach ($dataDep as $item)
                                    <option value="{{$item->id}}">{{strtoupper($item->name)}}</option>
                                @endforeach
                            </select>
                            @error('department_id') <span class="error">{{$message}}</span> @enderror
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="px-2 py-2">
                        <div >
                            <x-jet-label for="category" value="{{ __('Category') }}" />
                            <select wire:model="category_id" id="category_id" class="block mt-1 w-full rounded-md border-gray-400 shadow-sm opacity-70">
                                <option></option>
                                @foreach ($dataCat as $item)
                                    <option value="{{$item->id}}">{{strtoupper($item->name)}}</option>
                                @endforeach
                            </select>
                            @error('category_id') <span class="error">{{$message}}</span> @enderror
                        </div>
                    </td>
                    <td class="px-2 py-2">  
                        <div >
                            <span class="text-gray-700">Approval Right</span>
                            <div class="mt-2">
                                <label class="inline-flex items-center">
                                    <input type="radio" class="form-radio" wire:model="approvalRight" value="1">
                                    <span class="ml-2">Yes</span>
                                </label>
                                <label class="inline-flex items-center ml-6">
                                    <input type="radio" class="form-radio" wire:model="approvalRight" value="0">
                                    <span class="ml-2">No</span>
                                </label>
                            </div>
                        </div>
                    </td>
                </tr>
            </table>
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('modalFormVisible')" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-jet-secondary-button>

            <x-jet-button class="ml-2" wire:click="update" wire:loading.attr="disabled">
                {{ __('Update') }}
            </x-jet-danger-button>

        </x-slot>
    </x-jet-dialog-modal>

    <!-- Disable Modal -->
    <x-jet-dialog-modal wire:model="modalConfirmDisableVisible">
        <x-slot name="title">
            {{ __('Disable User') }}
        </x-slot>

        <x-slot name="content">
            {{ __('Are you sure you want to disable the user? Once a user is disabled, they will not be able to access the application.') }}

            </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('modalConfirmDisableVisible')" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-jet-secondary-button>

            <x-jet-danger-button class="ml-2" wire:click="disable" wire:loading.attr="disabled">
                {{ __('Disable') }}
            </x-jet-danger-button>
        </x-slot>
    </x-jet-dialog-modal>

        <!-- Enable Modal -->
        <x-jet-dialog-modal wire:model="modalConfirmEnableVisible">
        <x-slot name="title">
            {{ __('Enable User') }}
        </x-slot>

        <x-slot name="content">
            {{ __('Are you sure you want to enable the user? Once a user is enabled, they will have access to the application.') }}

            </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('modalConfirmEnableVisible')" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-jet-secondary-button>

            <x-jet-button class="ml-2" wire:click="enable" wire:loading.attr="disabled">
                {{ __('Enable') }}
            </x-jet-button>
        </x-slot>
    </x-jet-dialog-modal>

</div>

