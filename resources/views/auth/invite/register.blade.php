<x-guest-layout>

    <section class="bg-white dark:bg-gray-900">
        <div class="grid lg:h-screen lg:grid-cols-2">

            <div class="flex items-center justify-center px-4 py-6 lg:py-0 sm:px-0">

                <form class="w-full max-w-md space-y-4 md:space-y-6 xl:max-w-xl"   method="POST" action="{{ route('register',['domain'=>$domain]) }}">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white">{{$branding->tenant_name ??__('auth.tenant_name_backup')}}</h1>
                    @csrf


                    <div>
                        <x-jet-label for="name" value="{{ __('Name') }}" />
                        <x-jet-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                    </div>

                    <div class="hidden">
                        <x-jet-label for="csrf2" value="{{ __('CSRF2') }}" />
                        <x-jet-input id="csrf2" class="block mt-1 w-full" type="hidden" name="csrf2" value="{{request()->segments()[2] ?? 'none'}}" required  />
                        <x-jet-input id="domain" class="block mt-1 w-full" type="hidden" name="domain" value="{{request()->url('/')}}" required  />
                    </div>

                    <div>
                        <x-jet-label for="email" value="Email" />
                        <x-jet-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />  </div>
                    <div>
                        <x-jet-label for="password" value="{{ __('Password') }}" />
                        <x-jet-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
                    </div>

                    <div>
                        <x-jet-label for="password_confirmation" value="{{ __('Confirm Password') }}" />
                        <x-jet-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
                    </div>

                    <div class="space-y-3">
                        <div class="flex items-start">
                            @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                                <div class="mt-4">
                                    <x-jet-label for="terms">
                                        <div class="flex items-center">
                                            <x-jet-checkbox name="terms" id="terms"/>

                                            <div class="ml-2">
                                                {!! __('I agree to the :terms_of_service and :privacy_policy', [
                                                        'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" class="underline text-sm text-gray-600 hover:text-gray-900">'.__('Terms of Service').'</a>',
                                                        'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" class="underline text-sm text-gray-600 hover:text-gray-900">'.__('Privacy Policy').'</a>',
                                                ]) !!}
                                            </div>
                                        </div>
                                    </x-jet-label>
                                </div>
                            @endif
                        </div>
                        <div class="flex items-start">
                            <div class="flex items-center h-5">
                                <input id="newsletter" aria-describedby="newsletter" type="checkbox" class="w-4 h-4 bg-gray-50 rounded border border-gray-300 focus:ring-3 focus:ring-primary-300 dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-primary-600 dark:ring-offset-gray-800" required="">
                            </div>
                            <div class="ml-3 text-sm">
                                <label for="newsletter" class="font-light text-gray-500 dark:text-gray-300">Email me about product updates and resources.</label>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="w-full text-white bg-primary-600 hover:bg-primary-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-700">Create an account</button>
                    <div class="flex items-center justify-end mt-4">
                        <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                            {{ __('Already registered?') }}
                        </a>
                    </div>
                </form>
            </div>
            <div class="flex items-center justify-center px-4 py-6 {{$branding->colour1 ?? 'bg-primary-600'}} lg:py-0 sm:px-0" @if($branding->colour1) style="background-color: {{$branding->colour1}} " @endif>
                <div class="max-w-md xl:max-w-xl">
                    <a href="#" class="flex items-center mb-4 text-2xl font-semibold  {{$branding->colour2 ?? 'text-white'}}" @if($branding->colour2) style="color: {{$branding->colour2}} " @endif>
                        @if($branding->logo) <img class="h-16  mr-2" src="{{asset($branding->logo) ?? asset('/assets/final-logos-02.svg')}}" alt="{{$branding->tenant_name}} logo">@endif
                        @if(!$branding->logo)
                            <span class="capitalize">  {{$branding->tenant_name ??__('auth.tenant_name_backup')}}</span>
                        @endif
                    </a>
                    <h1 class="mb-4 text-3xl font-extrabold leading-none tracking-tight xl:text-5xl {{$branding->colour2 ?? 'text-white'}}" @if($branding->colour2) style="color: {{$branding->colour2}} " @endif> {{$branding->login ?? __('auth.login_side_lead')}}</h1>
                    <p class="mb-4 font-light  lg:mb-8 {{$branding->colour2 ?? 'text-white'}}" @if($branding->colour2) style="color: {{$branding->colour2}} " @endif>
                    {{$branding->register ?? __('auth.text_backup')}}

                </div>
            </div>
        </div>
    </section>

</x-guest-layout>
