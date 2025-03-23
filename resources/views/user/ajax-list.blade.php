@if(count($users) > 0)
@foreach ($users as $user)
@php
$filterClass = null;
if($hasFilter && $loop->first){
$filterClass = 'bg-success text-white';
}
@endphp
<tr class="{{ $filterClass }}">
    <td>{{ $user->id }}</td>
    <td>{{ $user->name }}</td>
    <td>{{ $user->email }}</td>
    <td>{{ $user->total_points }}</td>
    <td>#{{ $user->rank }}</td>
</tr>
@endforeach
@else
<tr class="">
    <td colspan="4" class="text-center">
        No Data Found
    </td>
</tr>
@endif