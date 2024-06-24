<x-mail::layout>
{{-- Header --}}
<x-slot:header>
<x-mail::header >
<span style=" text-transform: capitalize;">  {{ isset($tenantName) ? $tenantName : ($branding['tenant_name'] ?? '') }}</span>
</x-mail::header>
</x-slot:header>

{{-- Body --}}
{{ $slot }}

{{-- Subcopy --}}
@isset($subcopy)
<x-slot:subcopy>
<x-mail::subcopy>
{{ $subcopy }}
</x-mail::subcopy>
</x-slot:subcopy>
@endisset

{{-- Footer --}}
<x-slot:footer>
<x-mail::footer>
    © {{ date('Y') }}<span style=" text-transform: capitalize;"> {{ isset($tenantName) ? $tenantName : ($branding['tenant_name'] ?? '') }}</span>. @lang('All rights reserved.')
</x-mail::footer>
</x-slot:footer>
</x-mail::layout>
