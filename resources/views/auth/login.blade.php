<x-guest-layout>

    @section('title')
        {{$branding->tenant_name ??__('auth.tenant_name_backup')}}
    @endsection
    <section class="bg-white dark:bg-gray-900">
        <div class="grid lg:h-screen lg:grid-cols-2">
            <div class="flex items-center justify-center px-4 py-6 lg:py-0 sm:px-0">

                <form class="w-full max-w-md space-y-4 md:space-y-6 xl:max-w-xl"  method="POST" action="{{ route('login',$domain) }}">

                        @csrf
                    <h1 class="text-xl font-bold text-gray-900 dark:text-white">{{__('auth.login_welcome')}}  {{$branding->tenant_name ??__('auth.tenant_name_backup')}}</h1>
                    <x-jet-validation-errors class="mb-4" />

                    @if (session('status'))
                        <div class="mb-4 font-medium text-sm text-green-600">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div>
                        <x-jet-label for="email" value="Email" />
                        <x-jet-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
                    </div>

                    <div class="mt-4">
                        <x-jet-label for="password" value="{{ __('Password') }}" />
                        <x-jet-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex items-start">
                            <label for="remember_me" class="flex items-center">
                                <x-jet-checkbox id="remember_me" name="remember" />
                                <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                            </label>
                        </div>

                        @if (Route::has('password.request'))
                            <a class="text-sm font-medium text-primary-600 hover:underline dark:text-primary-500" href="{{ route('password.request',\request()->domain) }}">
                                {{ __('Forgot your password?') }}
                            </a>
                        @endif
                    </div>
                    <button type="submit" class="w-full  {{$branding->colour1 ?? 'bg-primary-600'}} {{$branding->colour2 ?? 'text-white'}} hover:bg-primary-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800" style="@if($branding->colour1) background-color: {{$branding->colour1}}; @endif @if($branding->colour2) color: {{$branding->colour2}}; @endif" >Sign in to your account</button>
                    <p class="text-sm font-light text-gray-500 dark:text-gray-400">
                        Don't have an account? <a href="{{route('register')}}" class="font-medium text-primary-600 hover:underline dark:text-primary-500">Sign up</a>
                    </p>
                </form>
            </div>
            <div class="flex items-center justify-center px-4 py-6 {{$branding->colour1 ?? 'bg-primary-600'}} lg:py-0 sm:px-0" @if($branding->colour1) style="background-color: {{$branding->colour1}} " @endif>
                <div class="max-w-md xl:max-w-xl">
                    <a href="#" class="flex items-center mb-4 text-2xl font-semibold  {{$branding->colour2 ?? 'text-white'}}" @if($branding->colour2) style="color: {{$branding->colour2}} " @endif>
                        @if($branding->logo)  <img class="h-16  mr-2" src="{{asset($branding->logo) ?? asset('/assets/final-logos-02.svg')}}" alt="logo">@endif
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
