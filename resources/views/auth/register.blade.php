<x-guest-layout class="pt-10">

    <!-- TITLE -->
    <div class="text-center mb-10 mt-10 md:mt-0">
        <h2 class="text-3xl font-extrabold text-blue-900 italic tracking-wide">Create Your Account</h2>
        <p class="text-gray-600">Fill in the details to register</p>
    </div>

    <form class="shadow-xl rounded-xl p-8 border border-gray-200" method="POST" action="{{ route('register') }}"
        enctype="multipart/form-data" class="space-y-6">
        @csrf

        <!-- FLEX WRAPPER (2 columns) -->
        <div class="flex flex-wrap gap-6 ">
            <!-- FIELD GROUP -->
            <div class="flex-1 min-w-[250px]">
                <x-input-label class="text-blue-900 text-[16px]" for="name">
                    Full Name <span class="text-red-600">*</span>
                </x-input-label>

                <x-text-input id="name" class="block mt-1 w-full" placeholder="Your full name" type="text"
                    name="name" :value="old('name')" required autofocus />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <div class="flex-1 min-w-[250px]">
                <x-input-label class="text-blue-900 text-[16px]" for="email">
                    Email Address <span class="text-red-600">*</span>
                </x-input-label>

                <x-text-input id="email" class="block mt-1 w-full" placeholder="abc@gmail.com" type="email"
                    name="email" :value="old('email')" required />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div class="flex-1 min-w-[250px]">
                <x-input-label class="text-blue-900 text-[16px]" for="phone">
                    Phone Number <span class="text-red-600">*</span>
                </x-input-label>

                <x-text-input id="phone" name="phone" type="text" class="block mt-1 w-full" required
                    placeholder="Must be 11 digits"
                    oninput="
                    // Add 0 at start if missing
                    if (this.value.length > 0 && this.value[0] !== '0') {
                        this.value = '0' + this.value;
                    }

                    // Limit to 11 digits
                    this.value = this.value.slice(0, 11);
                    "
                    maxlength="11" />


                <x-input-error :messages="$errors->get('phone')" class="mt-2" />
            </div>


            <div class="flex-1 min-w-[250px]">
                <x-input-label class="text-blue-900 text-[16px]" for="dob" :value="__('Date of Birth')" />
                <x-text-input id="dob" class="block mt-1 w-full" type="date" name="dob" :value="old('dob')"
                    required />
                <x-input-error :messages="$errors->get('dob')" class="mt-2" />
            </div>

            <div class="flex-1 min-w-[250px]">
                <x-input-label class="text-blue-900 text-[16px]" for="nid">
                    NID Number <span class="text-red-600">*</span>
                </x-input-label>
                <x-text-input id="nid" class="block mt-1 w-full" placeholder="Must be unique" type="number"
                    maxlength="10"
                    oninput=" 
                    // Limit to 10 digits
                    this.value = this.value.slice(0, 10);
                    "
                    name="nid" :value="old('nid')" required />

                <x-input-error :messages="$errors->get('nid')" class="mt-2" />
            </div>

            <div class="flex-1 min-w-[250px]">
                <x-input-label class="text-blue-900 text-[16px]" for="address" :value="__('Full Address')" />
                <x-text-input id="address" class="block mt-1 w-full" placeholder="Your full address" type="text"
                    name="address" :value="old('address')" required />
                <x-input-error :messages="$errors->get('address')" class="mt-2" />
            </div>

            <div class="flex-1 min-w-[250px]">
                <x-input-label class="text-blue-900 text-[16px]" for="occupation" :value="__('Occupation')" />
                <x-text-input id="occupation" class="block mt-1 w-full" type="text"
                    placeholder="student or add more details" name="occupation" :value="old('occupation')" required />
                <x-input-error :messages="$errors->get('occupation')" class="mt-2" />
            </div>

            <div class="flex-1 min-w-[250px]">
                <x-input-label class="text-blue-900 text-[16px]" for="income" :value="__('Monthly Income')" />
                <x-text-input id="income" class="block mt-1 w-full" placeholder="TK" type="number" name="income"
                    :value="old('income')" required />
                <x-input-error :messages="$errors->get('income')" class="mt-2" />
            </div>

            <div class="flex-1 min-w-[250px]">
                <x-input-label class="text-blue-900 text-[16px]" for="password" :value="__('Password')" />
                <x-text-input id="password" class="block mt-1 w-full" placeholder="At least 8 characters"
                    type="password" name="password" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div class="flex-1 min-w-[250px]">
                <x-input-label class="text-blue-900 text-[16px]" for="password_confirmation" :value="__('Confirm Password')" />
                <x-text-input id="password_confirmation" class="block mt-1 w-full"
                    placeholder="same as given password" type="password" name="password_confirmation" required
                    autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

        </div>

        <!-- FOOTER -->
        <div class="flex justify-between items-center pt-2">
            <a href="{{ route('login') }}" class="text-sm text-gray-600 hover:text-blue-900 underline">
                Already registered?
            </a>

            <x-primary-button class="bg-blue-900 hover:bg-blue-800 px-6 py-2 rounded-lg">
                {{ __('Register') }}
            </x-primary-button>
        </div>

    </form>

</x-guest-layout>
