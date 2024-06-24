<x-guest-layout>
    {{--{{dd($branding)}}--}}
    <section class="bg-white dark:bg-gray-900">
        <div class="grid h-screen lg:grid-cols-2">
            <div class="flex items-center justify-center min-h-1/2 px-4 py-6 lg:py-0 sm:px-0">
                <h1 class="text-4xl">You have been opted out</h1>
            </div>
            <div class="flex items-center justify-center min-h-1/2 px-4 py-6 {{$branding->colour1 ?? 'bg-primary-600'}} lg:py-0 sm:px-0" @if($branding->colour1) style="background-color: {{$branding->colour1}} " @endif>
                <div class="w-full  text-center mx-auto ">
                    <a href="#" class="flex justify-center items-center mb-4 text-2xl font-semibold w-full  {{$branding->colour2 ?? 'text-white'}}" @if($branding->colour2) style="color: {{$branding->colour2}} " @endif>
                        @if($branding->logo)  <img class="h-16  mr-2 " src="{{asset($branding->logo) ?? asset('/assets/final-logos-02.svg')}}" alt="logo">@endif
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
