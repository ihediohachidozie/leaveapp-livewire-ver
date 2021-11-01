<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __(strtoupper(Request::route()->getName())) }} 
    </h2>
</x-slot> 
<div class="p-6">
    <!--  The search bar -->
    <div class="flex space-x-4 items-center justify-end px-4 pb-3 text-right sm:px-6">
        <x-jet-input wire:model.debounce.100ms="search" id="search" class="block mt-1 w-1/2" type="text" placeholder="Enter staff name..."/>

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
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-700 uppercase tracking-wider">name</th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-700 uppercase tracking-wider">company</th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-700 uppercase tracking-wider">role</th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-700 uppercase tracking-wider">status</th>

                                <th class="px-6 py-3 bg-gray-50 text-right text-xs leading-4 font-medium text-gray-700 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @if ($data->count())
                                @foreach ($data as $item)
                                    <tr>
                                        <td class="px-6 py-4 text-sm whitespace-no-wrap">{{$item->id}}</td> 
                                        <td class="px-6 py-4 text-sm whitespace-no-wrap">{{ strtoupper($item->firstname)}}{{' '}}{{ strtoupper($item->lastname)}}</td>
                                        <td class="px-6 py-4 text-sm whitespace-no-wrap">{{ $item->company->name}}</td>
                                        <td class="px-6 py-4 text-sm whitespace-no-wrap">{{ $item->role->name}}</td>
   
                                        <td class="px-6 py-4 text-sm whitespace-no-wrap">
                                            @if ($item->status == 0)
                                                {{ strtoupper('disabled') }}
                                            @else
                                                {{ strtoupper('enabled') }}
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-right text-sm">

                                            @if($item->role_id == 3)
                                                <x-jet-button wire:click="superSuperShowModal({{ $item->id }})">
                                                    {{ __('Super User') }}
                                                </x-jet-button>
                                            @elseif ($item->role_id == 2)
                                                <x-jet-secondary-button wire:click="userShowModal({{$item->id}})">
                                                    {{ __('User') }}
                                                </x-jet-secondary-button>
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



    <!-- Disable Modal -->
    <x-jet-dialog-modal wire:model="modalConfirmSuperUserVisible">
        <x-slot name="title">
            {{ __('Super User Role') }} 
        </x-slot>

        <x-slot name="content">
            {{ __('Are you sure you want to upgrade '.$name.' to a super user role? Once a user is confirmed this role, they will granted more privileges to the application.') }}

            </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('modalConfirmSuperUserVisible')" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-jet-secondary-button>

            <x-jet-danger-button class="ml-2" wire:click="upgradeUser" wire:loading.attr="disabled">
                {{ __('Upgrade') }}
            </x-jet-danger-button>
        </x-slot>
    </x-jet-dialog-modal>

        <!-- Enable Modal -->
        <x-jet-dialog-modal wire:model="modalConfirmUserVisible">
        <x-slot name="title">
            {{ __('User Role') }}
        </x-slot>

        <x-slot name="content">
            {{ __('Are you sure you want to upgrade '.$name.' to a user role? Once a user is confirmed this role, they will granted less privileges to the application.') }}

            </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('modalConfirmUserVisible')" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-jet-secondary-button>

            <x-jet-danger-button class="ml-2" wire:click="downgradeUser" wire:loading.attr="disabled">
                {{ __('Downgrade') }}
            </x-jet-danger-button>
        </x-slot>
    </x-jet-dialog-modal>

</div>

