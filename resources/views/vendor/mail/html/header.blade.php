@props(['url'])
<tr>
<td class="header">
<a  style="display: inline-block;">
@if (trim($slot) === 'Laravel')
    @if($branding->logo)
        <img src="{{asset($branding->logo)}}" class="logo" alt="{{$branding->tenant_name}}">
        @else
            <img src="{{asset('/assets/final-logos-02.svg')}}" class="logo" alt="{{$branding->tenant_name}}">
    @endif

@else
{{ $slot }}
@endif
</a>
</td>
</tr>
