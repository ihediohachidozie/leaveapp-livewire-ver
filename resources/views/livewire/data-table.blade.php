<div>
    <tr>
        <td class="px-6 py-4 text-sm whitespace-no-wrap">
            {{ date_format(date_create($item->start_date), "d-m-Y")}}
             
        </td>
        <td class="px-6 py-4 text-sm whitespace-no-wrap">
            @livewire('end-date', ['startdate' => $item->start_date, 'days' => $item->days_applied])
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
        @if($item->user_id == auth()->id())
            @if($item->status == 0 || $item->status == 2)
                <td class="px-6 py-4 text-sm whitespace-no-wrap text-red-500">
                <a href="{{ route('update-leave', $item->id) }}">
                     {{$status[$item->status]}}
                </a>
                </td>
            @else
                <td class="px-6 py-4 text-sm whitespace-no-wrap">
                    {{$status[$item->status]}}
                </td>
            @endif
        @else
            <td class="px-6 py-4 text-sm whitespace-no-wrap">
                {{$status[$item->status]}}
            </td>
        @endif

    </tr>
</div>
