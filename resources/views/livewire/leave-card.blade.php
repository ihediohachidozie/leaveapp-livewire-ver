<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __(strtoupper(Request::route()->getName())) }} 
    </h2>
</x-slot>
<div class="p-6">
    <div class="flex items-center justify-end px-4 py-3 text-right sm:px-6">
        @if(auth()->user()->category_id)
            @if($canApply == 0)
                <x-jet-button wire:click="applyLeave">
                    {{ __('Apply') }}  
                </x-jet-button>
            @endif
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
                                                            
                                    @livewire('data-table', ['item' => $item], key($item->id))
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



</div>

   