<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>


    <main>
        <div class="max-w-9xl mx-auto px-32 pt-6 w-full ">
            <div class="px-4 sm:px-6 lg:px-8 py-8  ">
                <div class="relative bg-white p-4 sm:p-6 rounded-sm overflow-hidden mb-8">

                    <div class="relative">
                        <div class="flex justify-between items-center">
                            <div>
                                <h1 class="text-2xl md:text-3xl text-slate-800 font-bold mb-1">Hello, {{Auth::user()->name}} 👋</h1>
                                <p>Here is what’s happened over the last 3 months:</p>
                            </div>
                            <div>   <span class="font-bold text-xl">
                                Credits:
                              {{Auth::user()->currentTeam->credits->amount}}</span>
                            </div>


                        </div>

                    </div>
                </div>
                <div class="grid grid-cols-12 gap-6">
                    <div class="flex flex-col col-span-full sm:col-span-6 xl:col-span-6 bg-white shadow-lg rounded-sm border border-slate-200">
                        <div class="px-5 pt-5">
                            <h2 class="text-lg font-semibold text-slate-800 mb-2">Messages Scheduled</h2>
                            <div class="flex items-start">
                            </div>
                        </div>
                        <div class="grow p-4">
                            <div style="height: 22rem;">
                                <livewire:livewire-column-chart
                                        :column-chart-model="$MessagesPending"
                                />
                            </div> </div>
                    </div>
                    <div class="flex flex-col col-span-full sm:col-span-6 xl:col-span-6 bg-white shadow-lg rounded-sm border border-slate-200">
                        <div class="px-5 pt-5">
                            <h2 class="text-lg font-semibold text-slate-800 mb-2">Messages Sent</h2>
                            <div class="flex items-start">
                                <div class="text-3xl font-bold text-slate-800 mr-2"></div>
                            </div>
                        </div>
                        <div class="grow p-4">
                            <div style="height: 22rem;">
                                <livewire:livewire-column-chart
                                        :column-chart-model="$MessagesDelivered"
                                />
                            </div>
                        </div>
                    </div>
{{--                    <div class="flex flex-col col-span-full sm:col-span-6 xl:col-span-4 bg-white shadow-lg rounded-sm border border-slate-200">--}}
{{--                        <div class="px-5 pt-5">--}}
{{--                            <h2 class="text-lg font-semibold text-slate-800 mb-2">Messages Failed</h2>--}}
{{--                            <div class="flex items-start">--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="grow p-4">--}}
{{--                            <div style="height: 22rem;">--}}
{{--                            <livewire:livewire-column-chart--}}
{{--                                    :column-chart-model="$columnChartModel"--}}
{{--                            /></div>--}}
{{--                        </div>--}}
{{--                    </div>--}}


                    <div class="flex flex-col col-span-full sm:col-span-6 bg-white shadow-lg rounded-sm border border-slate-200">
                        <header class="px-5 py-4 border-b border-slate-100">
                            <h2 class="font-semibold text-slate-800">Contacts Added</h2></header>
                        <div class="grow p-4">
                            <div style="height: 22rem;">
                                <livewire:livewire-column-chart
                                        :column-chart-model="$ContactsCreated"
                                />
                            </div>
                        </div>
                    </div>
                    <div class="col-span-full xl:col-span-6 bg-white shadow-lg rounded-sm border border-slate-200">
                        <header class="px-5 py-4 border-b border-slate-100">
                            <h2 class="font-semibold text-slate-800">Contact Groups</h2></header>
                        <div class="p-3">
                            <div class="overflow-x-auto">
                                <table class="table-auto w-full">
                                    <thead class="text-xs uppercase text-slate-400 bg-slate-50 rounded-sm">
                                    <tr>
                                        <th class="p-2">
                                            <div class="font-semibold text-left">Group</div>
                                        </th>
                                        <th class="p-2">
                                            <div class="font-semibold text-center">Contacts</div>
                                        </th>
                                        <th class="p-2">
                                            <div class="font-semibold text-center">Created</div>
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody class="text-sm font-medium divide-y divide-slate-100">

                                    @foreach($ContactGroups as $group)
                                        <tr>
                                            <td class="p-2">
                                                <div class="flex items-center">
                                                    <div class="text-slate-800">{{$group->name}}</div>
                                                </div>
                                            </td>
                                            <td class="p-2">
                                                <div class="text-center">{{$group->contacts->count()}}</div>
                                            </td>
                                            <td class="p-2">
                                                <div class="text-center text-green-500">{{$group->created_at->format('d-m-Y')}}</div>
                                            </td>
                                    </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
            </div>


        </div>

    </main>


    <div class="py-12">
        <div class="">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">


            </div>
        </div>
    </div>
@push('js')

    @endpush
    <style>
        .checkbox:checked + .check-icon {
            display: flex;
        }
    </style>
</x-app-layout>
