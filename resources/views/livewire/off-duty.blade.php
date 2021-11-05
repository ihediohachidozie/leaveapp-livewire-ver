<div>
@if($data->count() > 0)
<ul>
    @foreach($data as $item)
    <li>
        {{$item->user->firstname}} {{' '}} {{$item->user->lastname}}
    </li>
    @endforeach
</ul>
    @endif
</div>
