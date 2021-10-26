<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __(strtoupper(Request::route()->getName())) }} 
    </h2>
</x-slot>
<div class="p-6">
    <!-- The Data Table -->
    <div class="flex flex-col">
        <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="text-center">
                @if (session()->has('message'))
                    <div class="alert alert-success text-green-500">
                        {{ session('message') }}
                    </div>
                @endif
            </div>
            <div class="py-2 align-middle inline-block w-full sm:px-6 lg:px-8">
                <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                    <table class="w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-700 uppercase tracking-wider">year</th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-700 text-center uppercase tracking-wider">days utilizied</th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-700 text-center uppercase tracking-wider">days outstanding</th>                              
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @if ($data->count())
                                @foreach ($data as $item)
                                <tr>                                    
                                    <td class="px-6 py-4 text-sm whitespace-no-wrap">
                                        {{ $item->year}}
                                        
                                    </td>
                                    <td class="px-6 py-4 text-sm whitespace-no-wrap text-center">
                                        {{$item->days}}
                                    </td>
                                    <td class="px-6 py-4 text-sm whitespace-no-wrap text-center">
                                        {{$item->outstanding}}
                                    </td>
                                </tr>
                                                            
                                @endforeach
                            @else
                                <tr>
                                    <td class="px-6 py-4 text-sm whitespace-no-wrap text-center" colspan ='3'>No Result Found</td>
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

   