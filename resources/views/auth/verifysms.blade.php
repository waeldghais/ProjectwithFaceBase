<x-guest-layout>
    <x-auth-card>
    <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </x-slot>
        @if (session('error'))
                    <div class="alert alert-danger" role="alert">
                        {{session('error')}}
                    </div>
                    @endif
                    Please enter the OTP sent to your number: {{session('phone_number')}}
       <form method="POST" action="{{route('verify')}}">
       @csrf

            <!-- Name -->
            <div>
                <x-label for="name" :value="__('Phone Number')" />
                
                <x-input id="phone_number" class="block mt-1 w-full" type="hidden" name="phone_number" value="{{session('phone_number')}}" />
                <x-input id="verification_code" class="block mt-1 w-full" type="text" name="verification_code" :value="old('verification_code')" required autofocus />
            </div>


            <div class="flex items-center justify-end mt-4">
                

                <x-button class="ml-4">
                    {{ __('Verify Phone Number') }}
                </x-button>
            </div>
        </form>
  
    </x-auth-card>
</x-guest-layout>
