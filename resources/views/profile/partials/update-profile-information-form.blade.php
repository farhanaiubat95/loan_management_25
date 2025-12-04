<form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="space-y-6">
    @csrf
    @method('patch')

    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Update Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Check your details and update them if needed.') }}
        </p>
    </header>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        {{-- Name --}}
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)"
                required />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        {{-- Email --}}
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)"
                required />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        {{-- Phone --}}
        <div>
            <x-input-label for="phone" :value="__('Phone Number')" />
            <x-text-input id="phone" name="phone" type="text" maxlength="11"
                oninput="this.value=this.value.replace(/[^0-9]/g,'').slice(0,11)" :value="old('phone', $user->phone)"
                class="mt-1 block w-full" />
            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
        </div>

        {{-- DOB --}}
        <div>
            <x-input-label for="dob" :value="__('Date of Birth')" />
            <x-text-input id="dob" name="dob" type="date" class="mt-1 block w-full" :value="old('dob', $user->dob)" />
            <x-input-error :messages="$errors->get('dob')" class="mt-2" />
        </div>


        {{-- Address (full width) --}}
        <div>
            <x-input-label for="address" :value="__('Address')" />
            <textarea id="address" name="address" class="mt-1 block w-full border-gray-300 rounded" rows="1">{{ old('address', $user->address) }}</textarea>
            <x-input-error :messages="$errors->get('address')" class="mt-2" />
        </div>

        {{-- Occupation --}}
        <div>
            <x-input-label for="occupation" :value="__('Occupation')" />
            <x-text-input id="occupation" name="occupation" type="text" class="mt-1 block w-full"
                :value="old('occupation', $user->occupation)" />
            <x-input-error :messages="$errors->get('occupation')" class="mt-2" />
        </div>

        {{-- Income --}}
        <div>
            <x-input-label for="income" :value="__('Monthly Income')" />
            <x-text-input id="income" name="income" type="number" class="mt-1 block w-full" :value="old('income', $user->income)" />
            <x-input-error :messages="$errors->get('income')" class="mt-2" />
        </div>

        {{-- Role --}}
        <div>
            <x-input-label for="role" :value="__('Role')" />
            <select id="role" name="role" class="mt-1 block w-full border-gray-300 rounded">
                <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>User</option>
                <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="manager" {{ $user->role == 'manager' ? 'selected' : '' }}>Manager</option>
            </select>
            <x-input-error :messages="$errors->get('role')" class="mt-2" />
        </div>

        {{-- NID Image --}}
        <div>
            <x-input-label for="nid_image" :value="__('NID Image')" />

            @if ($user->nid_image)
                <img src="{{ asset('storage/' . $user->nid_image) }}" class="mt-2 rounded border p-1" width="150">
            @endif

            <input id="nid_image" name="nid_image" type="file" class="mt-2 block w-full" />
            <x-input-error :messages="$errors->get('nid_image')" class="mt-2" />
        </div>

        {{-- NID --}}
        <div>
            <x-input-label for="nid" :value="__('NID Number')" />
            <x-text-input id="nid" name="nid" type="text" class="mt-1 block w-full" :value="old('nid', $user->nid)" />
            <x-input-error :messages="$errors->get('nid')" class="mt-2" />
        </div>

    </div>

    <div class="flex justify-end">
        <x-primary-button>Save Changes</x-primary-button>
    </div>

</form>
