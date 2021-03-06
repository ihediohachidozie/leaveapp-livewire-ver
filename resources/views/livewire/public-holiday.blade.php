<div class="p-6">
    <div class="flex items-center justify-end px-4 py-3 text-right sm:px-6">
        <x-jet-button wire:click="createShowModal">
            {{ __('Create') }}
        </x-jet-button>

    </div>

    <!-- The Data Table -->
    <div class="flex flex-col">
        <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="py-2 align-middle inline-block w-full sm:px-6 lg:px-8">
                <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                    <table class="w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-700 uppercase tracking-wider">S/N</th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-700 uppercase tracking-wider">Public Holiday</th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-700 uppercase tracking-wider">Date</th>
                                <th class="px-6 py-3 bg-gray-50 text-right text-xs leading-4 font-medium text-gray-700 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @if ($data->count())
                                @foreach ($data as $item)
                                    <tr>
                                        <td class="px-6 py-4 text-sm whitespace-no-wrap">{{$item->id}}</td>
                                        <td class="px-6 py-4 text-sm whitespace-no-wrap">{{ strtoupper($item->description)}}</td>
                                        <td class="px-6 py-4 text-sm whitespace-no-wrap">{{ $item->date}}</td>
                                        <td class="px-6 py-4 text-right text-sm">
                                            <x-jet-button wire:click="updateShowModal({{ $item->id }})">
                                                {{ __('Update') }}
                                            </x-jet-button>
                                            <x-jet-danger-button wire:click="deleteShowModal({{$item->id}})">
                                                {{ __('Delete') }}
                                            </x-jet-button>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td class="px-6 py-4 text-sm whitespace-no-wrap" colspan ='4'>No Result Found</td>
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
            {{ __('Edit Public Holiday') }} 
            @else
                {{ __('Add Public Holiday') }} 
            @endif
            
        </x-slot>

        <x-slot name="content">
            <div class="mt-4">
                <x-jet-label for="description" value="{{ __('Public Holiday') }}" />
                <x-jet-input wire:model.lazy="description" id="description" class="block mt-1 w-full" type="text" />
                @error('description') <span class="error">{{$message}}</span> @enderror
            </div>
            <div class="mt-4">
                <x-jet-label for="date" value="{{ __('Date') }}" />
                <x-jet-input wire:model.lazy="date" id="date" class="block mt-1 w-full" type="date"/>
                @error('date') <span class="error">{{$message}}</span> @enderror
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

    <!-- Detele Modal -->
    <x-jet-dialog-modal wire:model="modalConfirmDeleteVisible">
        <x-slot name="title">
            {{ __('Delete Holiday') }}
        </x-slot>

        <x-slot name="content">
            {{ __('Are you sure you want to delete the public holiday date? Once the public holiday date is deleted, all of its resources and data will be permanently deleted.') }}

            </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('modalConfirmDeleteVisible')" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-jet-secondary-button>

            <x-jet-danger-button class="ml-2" wire:click="delete" wire:loading.attr="disabled">
                {{ __('Delete') }}
            </x-jet-danger-button>
        </x-slot>
    </x-jet-dialog-modal>

</div>

