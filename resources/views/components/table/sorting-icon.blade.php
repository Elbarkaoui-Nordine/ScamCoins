@props(['field', 'order'])

<span class="text-sm text-gray-500 ml-1">
    @if($order === "{$field}_asc")
        &#9650;
    @elseif($order === "{$field}_desc")
        &#9660;
    @endif
</span>
