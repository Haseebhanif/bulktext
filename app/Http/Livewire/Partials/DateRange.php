<?php

namespace App\Http\Livewire\Partials;

use Carbon\Carbon;
use Haringsrob\LivewireDatepicker\Dto\DatePickerDayData;
use Haringsrob\LivewireDatepicker\Http\Livewire\DatePickerComponent;
use Livewire\Component;

class DateRange extends  DatePickerComponent
{
    // Pick any of the 3 options.
    public string $type = self::TYPE_RANGE_PICKER;

    public function getAvailabilityData(): \Illuminate\Support\Collection
    {
        return collect([
//            new DatePickerDayData(Carbon::yesterday(), classes: 'bg-red-500 text-white'),
//            new DatePickerDayData(Carbon::tomorrow(), classes: 'bg-yellow-500 text-white'),
//            new DatePickerDayData(Carbon::today(), classes: 'bg-green-500 text-white'),
//            new DatePickerDayData(date: Carbon::now()->setDay(31), disabled: true, cannotPickOver: true),
//            new DatePickerDayData(date: Carbon::now()->setDay(26), disabled: true, cannotPickOver: true),
        ]);
    }

    /**
     * This method is called whenever the date range or a new date is set.
     */
    public function onDatesSet(): void
    {
        $this->emit('rangeSet', ['from' => $this->startRange->format('Y-m-d'), 'till' => $this->endRange->format('Y-m-d')]);
    }

    /**
     * This method is called whenever the date range or a new date is unset.
     */
    public function onDatesUnSet(): void
    {
        $this->emit('rangeUnset');
    }
}
