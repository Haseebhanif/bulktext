<x-app-layout>

    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Invoices') }}
            </h2>
        </div>

    </x-slot>

    <main>

        <div class="bg-white">
            <div class="mx-auto max-w-7xl py-16 px-4 sm:px-6 lg:px-8 lg:pb-24">
                <div class="flex justify-between">
                    <div>
                        <h1 class="text-2xl font-bold tracking-tight text-gray-900 sm:text-3xl">Order history</h1>
                        <p class="mt-2 text-sm text-gray-500">Recent orders and download invoices.</p>
                    </div>


                </div>
                <?php

                $fmt = new NumberFormatter( 'en_GB', NumberFormatter::CURRENCY );

                ?>
                <div class="mt-8">
                    <h2 class="sr-only">Orders</h2>
                    <div class="space-y-5">
                    @foreach($invoices as $invoice)
                                <?php
                                    $incVat = 0.00;
                                    $incVat =  number_format(($invoice->amount/100+$invoice->vat),2);
                                ?>

                                <h3 class="sr-only">Order placed on <time datetime="{{$invoice->created_at}}">{{$invoice->created_at->format('M d Y H:i')}}</time></h3>

                                <div class="rounded-lg bg-gray-50 py-5 px-4 sm:flex sm:items-center sm:justify-between sm:space-x-6 sm:px-6 lg:space-x-4">
                                    <dl class="flex-auto space-y-6  text-sm text-gray-600 sm:grid sm:grid-cols-4 sm:gap-x-6 sm:space-y-0 sm:divide-y-0 lg:w-1/2 lg:flex-none lg:gap-x-8">
                                        <div class="flex justify-between pt-3 sm:block sm:pt-0">
                                            <dt class="font-medium text-gray-900">{{$invoice->company->company_name}}: Date placed</dt>
                                            <dd class="sm:mt-1">
                                                <time datetime="2021-01-22">{{$invoice->created_at->format('F d, Y H:i')}}</time>
                                            </dd>
                                        </div>
                                        <div class="flex justify-between pt-3 sm:block sm:pt-0">
                                            <dt class="font-medium text-gray-900">Order number </dt>
                                            <dd class="sm:mt-1">{{str_replace('pi_','DB_',$invoice->payment_ref)}}</dd>
                                        </div>
                                        <div class="flex justify-between pt-3 font-medium text-gray-900 sm:block sm:pt-0">
                                            <dt>Credits</dt>
                                            <dd class="sm:mt-1 uppercase">{{$invoice->credits}} </dd>
                                        </div>
                                        <div class="flex justify-between pt-3 font-medium text-gray-900 sm:block sm:pt-0">
                                            <dt>Total amount</dt>
                                            <dd class="sm:mt-1 uppercase">{{$invoice->currency}}  {{$fmt->formatCurrency(($invoice->amount / 100)-$invoice->vat,'GBP')}} ex Vat</dd>
                                            <dd class="sm:mt-1 uppercase">{{$invoice->currency}}  {{$fmt->formatCurrency(($invoice->amount / 100),'GBP')}} inc Vat</dd>
                                        </div>
                                    </dl>
                                    <a href="{{$isTLD ? route($prefix.'.invoice.download',$invoice->id) : route('invoice.download',['domain'=>session('domain'),$invoice->id])}}" class="mt-5 flex w-full items-center justify-center rounded-md border border-gray-300 bg-white py-2 px-4 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:mt-0 sm:w-auto">
                                        View Invoice
                                        <span class="sr-only">for order {{str_replace('pi_','DB_',$invoice->payment_ref)}}</span>
                                    </a>
                                </div>

                    @endforeach</div>
                </div>
                <div class="py-4">
                    {{$invoices->links()}}
                </div>


                </div>

            </div>
        </div>







    </main>

</x-app-layout>
