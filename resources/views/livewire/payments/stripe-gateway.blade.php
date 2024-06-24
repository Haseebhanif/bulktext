<div>

    <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
        {{--   Buy Credits --}}
        <div class="md:grid md:grid-cols-3 my-10 md:gap-6">
            <div class="md:col-span-1 flex justify-between">
                <div class="px-4 sm:px-0">
                    <h3 class="text-lg font-medium text-gray-900">Buy Credits</h3>

                    <p class="mt-1 text-sm text-gray-600">
                        Credits allow you to send messages. <br>Min credit amount is 500
                    </p>
                </div>

                <div class="px-4 sm:px-0">

                </div>
            </div>

            <div class="mt-5 md:mt-0 md:col-span-2">
                <div class="px-4 py-5 bg-white sm:p-6 shadow sm:rounded-tl-md sm:rounded-tr-md">
                    <div class="grid grid-cols-6 gap-6">
                        <div class="col-span-6">
                            <div>
                                <legend class="sr-only">Pricing plans</legend>
                                <div class="relative -space-y-px  rounded-md bg-white my-2">


                                        <div class="flex justify-center items-center">


                                                      <div class="rounded-md border border-gray-300 px-3 py-2 shadow-sm focus-within:border-indigo-600 focus-within:ring-1 focus-within:ring-indigo-600">
                                                          <label for="name" class="block text-xs font-medium text-gray-900">Credits Required</label>
                                                          <input min="100" wire:model.debounce.1000ms="creditsWanted" type="number" name="name" id="name" class="block w-full border-0 p-0 text-gray-900 placeholder-gray-500 focus:ring-0 sm:text-sm" placeholder="Credits">
                                                      </div>

                                                    <div class="text-center mx-auto  px-5 grid grid-cols-6">
                                                        <span class="text-md w-full col-span-6">@rate {{$creditRate}} per credit </span>
                                                        <span class="text-xl w-full  col-span-6"> £ {{$creditsPrice}}  ex vat </span>
                                                    </div>


                                                    <div class="text-center mx-auto  px-5">

                                                        @if($creditChange)
                                                          <span class="text-dbfb2 text-xl">
                                                                Calculating
                                                          </span>


                                                            @else

                                                        <button  wire:click="$set('confirmPurchase',true)"  class="bg-dbfb2 w-full text-white py-2 px-10 hover:bg-dbfb1" >
                                                            Pay Now  £ {{$creditsPrice}}  ex vat
                                                        </button>

                                                            @endif

                                                    </div>


                                         </div>


                                    <!-- Stripe Elements Placeholder -->
                                    <div class="mb-3">

                                    </div>


                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        {{--  Card details--}}
        <div class="md:grid md:grid-cols-3  md:gap-6"   >
            <div class="md:col-span-1 flex justify-between">
                <div class="px-4 sm:px-0">
                    <h3 class="text-lg font-medium text-gray-900">Payment  Methods</h3>

                    <p class="mt-1 text-sm text-gray-600">
                        Manage your payment methods here.
                    </p>
                </div>

                <div class="px-4 sm:px-0">

                </div>
            </div>

            <div class="mt-5 md:mt-0 md:col-span-2">
                <form>
                    <div class=" py-5    ">
                        <div class="grid grid-cols-6 gap-1">
                            @if(count($paymentMethods) == 0)
                                <button type="button" class="col-span-6 relative block w-full rounded-lg border-2 border-dashed border-gray-300 p-12 text-center hover:border-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                    <span class="mt-2 block text-sm font-medium text-gray-900">No payment methods supplied</span>
                                </button>
                            @else

                                @foreach($paymentMethods as $cardType)
                            <div class="col-span-6 bg-white">
                                <div>

                                    <div class="relative -space-y-px rounded-md bg-white">




        <div>
            <!-- Checked: "bg-indigo-50 border-indigo-200 z-10", Not Checked: "border-gray-200" -->
            <label class="rounded-tl-md rounded-tr-md relative border p-4  flex flex-col cursor-pointer md:pl-4 md:pr-6 md:grid md:grid-cols-3 focus:outline-none">
                                                <span class="flex items-center text-sm">
                                                    <input wire:model="paymentMethod" wire:click="setDefaultCard('{{$cardType->id}}')" type="radio" name="pricing-plan" value="{{$cardType->id}}" class="h-4 w-4 text-indigo-600 border-gray-300 focus:ring-indigo-500" aria-labelledby="pricing-plans-0-label" aria-describedby="pricing-plans-0-description-0 pricing-plans-0-description-1">
                                                    <!-- Checked: "text-indigo-900", Not Checked: "text-gray-900" -->
                                                    <span id="pricing-plans-0-label" class="ml-3 font-medium text-sm"> {{$cardType->billing_details->name}}</span>
                                                </span>

                <div id="pricing-plans-0-description-0" class="ml-6 pl-1 text-sm md:ml-0 md:pl-0  ">
                    <!-- Checked: "text-indigo-900", Not Checked: "text-gray-900" -->
                    <div class="md:grid md:grid-cols-3 ">
                        <div class="col-span-3">
                            <span class="font-medium w-full">**** **** **** {{$cardType->card->last4}} </span>
                        </div>
                        <div class="col-span-3 flex justify-between">
                            <!-- Checked: "text-indigo-700", Not Checked: "text-gray-500" -->
                            <span class="w-full">Exp: {{$cardType->card->exp_month}}&nbsp;/&nbsp;{{$cardType->card->exp_year}}</span>
                            <span class="font-medium w-full">{{$cardType->card->brand}}</span>
                        </div>
                    </div>
                </div>

                <!-- Checked: "text-indigo-700", Not Checked: "text-gray-500" -->
                <span id="pricing-plans-0-description-1" class="ml-6 pl-1 text-sm md:ml-0 md:pl-0 md:text-right">
                                                        <span class="mx-4 text-red-500" wire:click="remove('{{$cardType->id}}')">Remove</span>
                                                </span>
            </label>
        </div>



                                    </div>
                                </div>
                            </div>
                                @endforeach

                            @endif

                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{--  New Card details--}}
        <div class="md:grid md:grid-cols-3 my-10 md:gap-6">
            <div class="md:col-span-1 flex justify-between">
                <div class="px-4 sm:px-0">
                    <h3 class="text-lg font-medium text-gray-900">Add Payment Method</h3>

                    <p class="mt-1 text-sm text-gray-600">
                        Add a payment method.
                    </p>
                </div>

                <div class="px-4 sm:px-0">

                </div>
            </div>

            <div class="mt-5 md:mt-0 md:col-span-2">
                    <div class="px-4 py-5 bg-white sm:p-6 shadow sm:rounded-tl-md sm:rounded-tr-md">
                        <div class="grid grid-cols-6 gap-6">
                            <div class="col-span-6">
                                <div>
                                    <legend class="sr-only">Pricing plans</legend>
                                    <div class="relative -space-y-px  rounded-md bg-white my-2">
                                        <div class="flex flex-col mb-3">
                                            <label for="card-holder-name">Name on card</label>
                                            <input  id="card-holder-name" type="text">
                                        </div>


                                        <!-- Stripe Elements Placeholder -->
                                        <div class="mb-3">
                                            <div id="card-element" class="p-5 border border-gray-500 "></div>
                                        </div>

                                        <div class="my-3">
                                        <button  class="bg-dbfb2 mt-3 text-white p-2 hover:bg-dbfb1" id="card-button" data-secret="{{ $intent->client_secret }}">
                                            Add Payment Method
                                        </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
            </div>
        </div>
     </div>


    <x-jet-confirmation-modal wire:model="confirmPurchase"  >
        <x-slot name="title">
           Confirm you purchase of {{$creditsWanted}} credits
        </x-slot>

        <x-slot name="content">
            @php
                $total = $creditsPrice + $vat;
            @endphp
            You will be charged a total of £{{ number_format($total, 2) }} inc vat to your default payment method.
        </x-slot>


        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$set('confirmPurchase',false)">
                cancel
            </x-jet-secondary-button>

            <x-jet-danger-button class="ml-2" wire:click="processPayment"  >
                proceed
            </x-jet-danger-button>
        </x-slot>
    </x-jet-confirmation-modal>


    <script src="https://js.stripe.com/v3/"></script>

    <script>
        document.addEventListener('DOMContentLoaded', () => {

            Livewire.on('reloadScript', () => {

                const stripe = Stripe('{{$this->stripeKey}}');

                const elements = stripe.elements();
                const cardElement = elements.create('card');

                cardElement.mount('#card-element');


                const cardHolderName = document.getElementById('card-holder-name');
                const cardButton = document.getElementById('card-button');
                const clientSecret = cardButton.dataset.secret;

                cardButton.addEventListener('click', async (e) => {
                    cardButton.disabled = true
                    const {setupIntent, error} = await stripe.confirmCardSetup(
                        clientSecret, {
                            payment_method: {
                                card: cardElement,
                                billing_details: {name: cardHolderName.value}
                            }
                        }
                    );

                    if (error) {
                        Livewire.emit('errorMessage', error)
                        // Display "error.message" to the user...
                        cardButton.disabled = false

                        Livewire.emit('refreshCard')

                    } else {
                        Livewire.emit('paymentMethodUpdated', setupIntent.payment_method)
                        cardButton.disabled = false
                        Livewire.emit('refreshCard')
                        Livewire.emit('defaultCard')
                        let newUrl = window.location.href;

                        setTimeout(()=>{
                            window.location.href = newUrl;
                        },2000)

                        // The card has been verified successfully...
                    }
                });
            });

            Livewire.emit('reloadScript');
        });
    </script>
</div>


