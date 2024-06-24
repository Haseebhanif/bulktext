
<div>
    @push('css')
       @endpush


        <div class="grid grid-cols-1 gap-1">
            <label for="date">Send Date</label>
            <x-date-picker wire:model="date" id="date"/>
        </div>

</div>

