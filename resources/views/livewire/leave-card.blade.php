<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __(strtoupper(Request::route()->getName())) }} 
    </h2>
</x-slot>
<div class="p-6">
    @if(auth()->user()->category_id)
        <div class="flex items-center justify-end px-4 py-3 text-right sm:px-6">
            <x-jet-button wire:click="createShowModal">
                {{ __('Apply') }}
            </x-jet-button>
        </div>
    @endif

    <!-- The Data Table -->
    <div class="flex flex-col">
        <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="py-2 align-middle inline-block w-full sm:px-6 lg:px-8">
                <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                    <table class="w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-700 uppercase tracking-wider">start date</th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-700 uppercase tracking-wider">end date</th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-700 uppercase tracking-wider">resumption date</th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-700 uppercase tracking-wider">days</th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-700 uppercase tracking-wider">leave type</th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-700 uppercase tracking-wider">year</th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-700 uppercase tracking-wider">duty reliever</th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-700 uppercase tracking-wider">approval</th>
                                <th class="px-6 py-3 bg-gray-50 text-right text-xs leading-4 font-medium text-gray-700 uppercase tracking-wider">status</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @if ($data->count())
                                @foreach ($data as $item)
                                    <tr>
                                        <td class="px-6 py-4 text-sm whitespace-no-wrap">
                                            {{ date_format(date_create($item->start_date), "d-m-Y")}}
                                         
                                        </td>
                                        <td class="px-6 py-4 text-sm whitespace-no-wrap">
                                            @livewire('end-date', ['startdate' => $item->start_date, 'days' => $item->days_applied ])
                                        </td>
                                        <td class="px-6 py-4 text-sm whitespace-no-wrap">
                                            @livewire('resumption-date', ['startdate' => $item->start_date, 'days' => $item->days_applied ])
                                            
                                        </td>
                                        <td class="px-6 py-4 text-sm whitespace-no-wrap">{{$item->days_applied}}</td>
                                        <td class="px-6 py-4 text-sm whitespace-no-wrap">
                                            {{$leaveType[$item->leave_type]}}
                                        </td>
                                        <td class="px-6 py-4 text-sm whitespace-no-wrap">{{$item->year}}</td>
                                        <td class="px-6 py-4 text-sm whitespace-no-wrap">
                                            @livewire('get-name', ['userid' => $item->duty_reliever])
                                        </td>
                                        <td class="px-6 py-4 text-sm whitespace-no-wrap">
                                            @livewire('get-name', ['userid' => $item->approval_id])
                                        </td>
                                        <td class="px-6 py-4 text-sm whitespace-no-wrap">{{$item->status}}</td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td class="px-6 py-4 text-sm whitespace-no-wrap text-center" colspan ='9'>No Result Found</td>
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
            {{ __('Edit Leave') }} 
            @else
                {{ __('New Leave') }} 
            @endif
            
        </x-slot>

        <x-slot name="content">
            <table class="w-full">
                <tr>
                    <td>
                        <div class="mt-4">
                            <x-jet-label for="start_date" value="{{ __('Start Date') }}" />
                            <x-jet-input wire:model.lazy="start_date" id="start_date" class="block mt-1 w-full" type="date"/>
                            @error('start_date') <span class="error">{{$message}}</span> @enderror
                        </div>
                    </td>
                    <td>
                        <div class="mt-4">
                            <x-jet-label for="days_applied" value="{{ __('Approved Days') }}" />
                            <x-jet-input wire:model.lazy="days_applied" id="days_applied" class="block mt-1 w-full" type="number"/>
                            @error('days_applied') <span class="error">{{$message}}</span> @enderror
                        </div>
                    </td>

                </tr>
                <tr>
                    <td>
                        <div class="mt-4">
                            <x-jet-label for="year" value="{{ __('Leave Year') }}" />
                            <select wire:model="year" id="year" class="block mt-1 w-full rounded-md border-gray-400 shadow-sm opacity-70">
                                <option></option>
                                @for ($x = 2007; $x <= 2050; $x++)
                                    <option value="{{$x}}">{{$x}}</option>
                                @endfor
                            </select>
                            @error('year') <span class="error">{{$message}}</span> @enderror
                        </div>
                    </td>
                    <td>
                        <div class="mt-4">
                            <x-jet-label for="leave_type" value="{{ __('Leave Type') }}" />
                            <select wire:model="leave_type" id="leave_type" class="block mt-1 w-full rounded-md border-gray-400 shadow-sm opacity-70">
                                <option></option>    
                                <option value="0">Annual</option>
                                <option value="1">Casual</option>
                                <option value="2">Maternity</option>
                                <option value="3">Paternity</option>
                                <option value="4">Study</option>                                
                                <option value="5">Sick</option>
                                <option value="6">Examination</option>
                                <option value="7">Sabbatical</option>                                
                            </select>
                            @error('leave_type') <span class="error">{{$message}}</span> @enderror
                        </div>
                    </td>

                </tr>
                <tr>
                    <td>
                        <div class="mt-4">
                            <x-jet-label for="duty_reliever" value="{{ __('Duty Reliever') }}" />
                            <select wire:model="duty_reliever" id="duty_reliever" class="block mt-1 w-full rounded-md border-gray-400 shadow-sm opacity-70">
                                <option></option>
                                @if ($users->count())
                                    @foreach ($users as $user)
                                        <option value="{{$user->id}}">{{$user->name}}</option>
                                    @endforeach
                                @endif
                            </select>
                            @error('duty_reliever') <span class="error">{{$message}}</span> @enderror
                        </div>
                    </td>
                    <td>
                        <div class="mt-4">
                            <x-jet-label for="approval_id" value="{{ __('Approved By') }}" />
                            <select wire:model="approval_id" id="approval_id" class="block mt-1 w-full rounded-md border-gray-400 shadow-sm opacity-70">
                                <option></option>
                                @if ($approvals->count())
                                    @foreach ($approvals as $approval)
                                        <option value="{{$approval->id}}">{{$approval->name}}</option>
                                    @endforeach
                                @endif
                            </select>
                            @error('approval_id') <span class="error">{{$message}}</span> @enderror
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                    <div class="mt-2">
                        <span class="text-gray-700">Leave Allowance</span>
                        <div class="mt-2">
                            <label class="inline-flex items-center">
                                <input type="radio" class="form-radio" wire:model="allowance" value="1">
                                <span class="ml-2">Pay Now</span>
                            </label>
                            <label class="inline-flex items-center ml-6">
                                <input type="radio" class="form-radio" wire:model="allowance" value="2">
                                <span class="ml-2">Pay Later</span>
                            </label>
                            <label class="inline-flex items-center ml-6">
                                <input type="radio" class="form-radio" wire:model="allowance" value="3">
                                <span class="ml-2">Paid</span>
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

            @if($modelId)

                <x-jet-button class="ml-2" wire:click="update" wire:loading.attr="disabled">
                    {{ __('Update') }}
                </x-jet-danger-button>
            @else
                <x-jet-button class="ml-2" wire:click="create" wire:loading.attr="disabled">
                    {{ __('Apply') }}
                </x-jet-danger-button>

            @endif
        </x-slot>
    </x-jet-dialog-modal>

</div>

   