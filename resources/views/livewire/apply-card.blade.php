<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __(strtoupper(Request::route()->getName())) }} 
    </h2>
</x-slot>
<div class="p-6">
    <x-jet-form-section submit="create">
        <x-slot name="title">
            {{ __('Leave Form') }}
        </x-slot>

        <x-slot name="description">
            {{ __('Complete all the fields provided and click on Apply button to send it for approval.') }}
        </x-slot>

        <x-slot name="form">
            <!--Start Date-->
            <div class="col-span-6 sm:col-span-4">
                <table class="w-full">
                    <tr>
                        <td>
                            <x-jet-label for="start_date" value="{{ __('Start Date') }}" />
                            <x-jet-input wire:model.lazy="start_date" id="start_date" class="block mt-1 w-full" type="date"/>
                            @error('start_date') <span class="error">{{$message}}</span> @enderror
         
                        </td>
                        <td>
                            <x-jet-label for="days_applied" value="{{ __('Approved Days') }}" />
                            <x-jet-input wire:model.lazy="days_applied" id="days_applied" class="block mt-1 w-full" type="number"/>
                            @error('days_applied') <span class="error">{{$message}}</span> @enderror
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
                                            <option value="{{$user->id}}">{{$user->firstname}} {{' '}} {{$user->lastname}}</option>
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
                                            <option value="{{$approval->id}}">{{$approval->firstname}}</option>
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
                                @error('allowance') <span class="error">{{$message}}</span> @enderror
                            </div>

                        </td>
                    </tr>
                </table>
            </div>
        </x-slot>

        <x-slot name="actions">
            <div class="text-right sm:px-6">
            @if (session()->has('success'))
                <span class="error text-green-500 ">
                    {{ session('success') }}
                </span>
            @elseif (session()->has('session'))
                <span class="error text-red-500 ">
                    {{ session('session') }}
                </span>
            @endif
            </div>
            <x-jet-secondary-button wire:click="back" wire:loading.attr="disabled" class="mr-2" >
                {{ __('Cancel') }}
            </x-jet-secondary-button>

            <x-jet-button  wire:loading.attr="disabled" wire:target="photo">
                {{ __('Apply') }}
            </x-jet-button>
        </x-slot>
    </x-jet-form-section>

</div>
