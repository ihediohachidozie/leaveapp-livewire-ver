<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __(strtoupper(Request::route()->getName())) }} 
    </h2>
</x-slot>
<div class="p-6">
    <x-jet-form-section submit="approveLeave">
        <x-slot name="title">
            {{ __('Leave Approval Form') }}
        </x-slot>

        <x-slot name="description">
            {{ __('Update your account\'s profile information and email address.') }}
            
        </x-slot>

        <x-slot name="form">
            <!--Start Date-->
            <div class="col-span-6 sm:col-span-4">
                <div class="mt-2">
                    <span class="text-gray-900">Leave Allowance</span>
                    <div class="mt-2">
                        <label class="inline-flex items-center">
                            <input type="radio" class="form-radio" wire:model="statusResult" value="3">
                            <span class="ml-2">Approved</span>
                        </label>
                        <label class="inline-flex items-center ml-6">
                            <input type="radio" class="form-radio" wire:model="statusResult" value="2">
                            <span class="ml-2">Rejected</span>
                        </label>
                    </div>
                    @error('allowance') <span class="error">{{$message}}</span> @enderror
                </div>
                <div class="mt-4">
                    <x-jet-label for="comment" value="{{ __('Comment') }}" />
                    <textarea wire:model="comment" id="comment" cols="50" rows="5" class="resize-none border rounded-md"></textarea>
                   
                </div>
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

            @if ($status == 3)
            <x-jet-button  wire:loading.attr="disabled" wire:target="photo" disabled>
                {{ __('Send') }}
            </x-jet-button>
            @elseif ($status == 1)
            <x-jet-button  wire:loading.attr="disabled" wire:target="photo">
                {{ __('Send') }}
            </x-jet-button>
            @endif
        </x-slot>
    </x-jet-form-section>

</div>
