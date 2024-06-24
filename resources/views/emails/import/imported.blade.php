<x-mail::message>
# Import Complete

{{ $importInfo->success_count}} contact have been imported/updated,{{ $importInfo->error_count == 0 ? ' with no errors.': ' we had issues with '.$importInfo->error_count.'.'}}
    <br>
{{'Please check the import user wizard in the console for details.'}}

</x-mail::message>
