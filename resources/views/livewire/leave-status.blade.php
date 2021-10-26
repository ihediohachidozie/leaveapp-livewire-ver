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
                    <table class="w-full divide-y divide-gray-200" id="example">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-700 uppercase tracking-wider">Staff</th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-700 uppercase tracking-wider">start date</th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-700 uppercase tracking-wider">end date</th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-700 uppercase tracking-wider">resumption date</th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-700 uppercase tracking-wider">days</th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-700 uppercase tracking-wider">leave type</th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-700 uppercase tracking-wider">year</th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-700 uppercase tracking-wider">duty reliever</th>
                                <th class="px-6 py-3 bg-gray-50 text-right text-xs leading-4 font-medium text-gray-700 uppercase tracking-wider">status</th>
                                
                                
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @if ($data->count())
                                @foreach ($data as $item)
                                    <tr>
                                        
                                        <td class="px-6 py-4 text-sm whitespace-no-wrap">
                                            
                                            {{$item->user->firstname}}{{' '}}{{$item->user->lastname}} 
                                        </td>
                                        
                                        <td class="px-6 py-4 text-sm whitespace-no-wrap">
                                            {{ date_format(date_create($item->start_date), "d-m-Y")}}
                                            
                                        </td>
                                        <td class="px-6 py-4 text-sm whitespace-no-wrap">
                                            @livewire('end-date', ['startdate' => $item->start_date, 'days' => $item->days_applied], key($item->id))
                                        </td>
                                        <td class="px-6 py-4 text-sm whitespace-no-wrap">
                                            @livewire('resumption-date', ['startdate' => $item->start_date, 'days' => $item->days_applied], key($item->id))
                                            
                                        </td>
                                        <td class="px-6 py-4 text-sm whitespace-no-wrap">{{$item->days_applied}}</td>
                                        <td class="px-6 py-4 text-sm whitespace-no-wrap">
                                            {{$leaveType[$item->leave_type]}}
                                        </td>
                                        <td class="px-6 py-4 text-sm whitespace-no-wrap">{{$item->year}}</td>
                                        <td class="px-6 py-4 text-sm whitespace-no-wrap">
                                            @livewire('get-name', ['userid' => $item->duty_reliever], key($item->id))
                                        </td>
                                        
                                        <td class="px-6 py-4 text-sm whitespace-no-wrap ">
                                            {{$status[$item->status]}}
                                            
                                        </td>

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


</div>

   