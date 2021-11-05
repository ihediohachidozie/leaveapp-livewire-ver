<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __(strtoupper(Request::route()->getName())) }} 
    </h2>
</x-slot>
<div class="p-6">
    <div class="flex items-center justify-end px-4 py-3 text-right sm:px-6">
        @if($checkRoster == 0)
        <x-jet-button wire:click="createShowModal">
            {{ __('Add') }}
        </x-jet-button>
        @endif

    </div>

    <!-- The Data Table -->
    <div class="flex flex-col">
        <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="py-2 align-middle inline-block w-full sm:px-6 lg:px-8">
                <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                    <table class="w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <!-- <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-700 uppercase tracking-wider">S/N</th> -->
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-700 uppercase tracking-wider">Staff</th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-700 uppercase tracking-wider">Commencement date</th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-700 uppercase tracking-wider">Status</th>

                                <th class="px-6 py-3 bg-gray-50 text-right text-xs leading-4 font-medium text-gray-700 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @if ($data->count())
                                @foreach ($data as $item)
                                    <tr>
                                        <!-- <td class="px-6 py-4 text-sm whitespace-no-wrap">{{$item->id}}</td> -->
                                        <td class="px-6 py-4 text-sm whitespace-no-wrap">{{ strtoupper($item->user->firstname)}}{{' '}}{{ strtoupper($item->user->lastname)}}</td>
                                        <td class="px-6 py-4 text-sm whitespace-no-wrap">{{ date_format(date_create($item->commencement_date), "d-m-Y")}}</td>
                                        <td class="px-6 py-4 text-sm whitespace-no-wrap">{{$status[$item->status]}}</td>
                                        <td class="px-6 py-4 text-right text-sm">
                                            @if($item->user_id == auth()->id() && $item->status < 2)
                                            <x-jet-button class="ml-2" wire:click="updateShowModal({{ $item->id }})" >
                                                {{ __('Edit') }}
                                            </x-jet-button>
                                            @endif
                                            @if(auth()->user()->approval_right == 1 && $item->status < 2)
                                            <x-jet-danger-button wire:click="approveShowModal({{$item->id}})">
                                                {{ __('Approve') }}
                                            </x-jet-button>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td class="px-6 py-4 text-sm whitespace-no-wrap text-center" colspan ='5'>No Result Found</td>
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
            @if($modelId)
                {{ __('Edit Date') }}
            @else
                {{ __('Add Date') }} 
            @endif
            
        </x-slot>

        <x-slot name="content">
            <div class="mt-4">
                <x-jet-label for="commencement_date" value="{{ __('Commencement Date') }}" />
                <x-jet-input wire:model.lazy="commencement_date" id="commencement_date" class="block mt-1 w-full" type="date" />
                <div class="text-right sm:px-6">
                    @if (session()->has('session'))
                        <span class="error text-red-500 ">
                            {{ session('session') }}
                        </span>
                    @endif
                </div>
            </div>
        </x-slot>


        <x-slot name="footer">

            <x-jet-secondary-button wire:click="$toggle('modalFormVisible')" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-jet-secondary-button>

            @if($modelId)

            <x-jet-button class="ml-2" wire:click="update" wire:loading.attr="disabled">
                {{ __('Update') }}
            </x-jet-danger-button>
            @else
            <x-jet-button class="ml-2" wire:click="create" wire:loading.attr="disabled">
                {{ __('Create') }}
            </x-jet-danger-button>

            @endif

        </x-slot>
    </x-jet-dialog-modal>

    <!-- Approve Modal -->
    <x-jet-dialog-modal wire:model="modalConfirmApproveVisible">
        <x-slot name="title">
            {{ __('Approve Commencement') }}
        </x-slot>

        <x-slot name="content">
            {{ __('Are you sure you want to approve this date? Once approved, staff can proceed on leave on this date.') }}

            </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('modalConfirmApproveVisible')" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-jet-secondary-button>

            <x-jet-danger-button class="ml-2" wire:click="approve" wire:loading.attr="disabled">
                {{ __('Approve') }}
            </x-jet-danger-button>
        </x-slot>
    </x-jet-dialog-modal>


</div>
