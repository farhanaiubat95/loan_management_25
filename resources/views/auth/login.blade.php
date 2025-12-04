<x-guest-layout>

    <div class="flex justify-center mb-8">
        <h1 class="text-3xl font-extrabold text-blue-900 italic tracking-wide">
            {{ __('Login to Your Account') }}
        </h1>
    </div>

    <!-- Outer Container -->
    <div class=" shadow-xl rounded-xl p-8 border border-gray-200">

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}" class="space-y-6">
            @csrf

            <!-- Email Address -->
            <div>
                <x-input-label class="text-blue-900 font-semibold" for="email" :value="__('Email Address')" />

                <div class="mt-1 relative">
                    <input 
                        id="email" 
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        required
                        autofocus
                        autocomplete="username"
                        class="block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-700 focus:border-blue-700 px-4 py-2"
                    >
                </div>

                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div>
                <x-input-label class="text-blue-900 font-semibold" for="password" :value="__('Password')" />

                <input 
                    id="password" 
                    type="password"
                    name="password"
                    required
                    autocomplete="current-password"
                    class="block mt-1 w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-700 focus:border-blue-700 px-4 py-2"
                >

                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Remember Me -->
            <div class="flex items-center justify-between">
                <label for="remember_me" class="flex items-center cursor-pointer">
                    <input 
                        id="remember_me"
                        type="checkbox"
                        name="remember"
                        class="rounded border-gray-300 text-blue-900 shadow-sm focus:ring-blue-700"
                    >
                    <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                </label>

                @if (Route::has('password.request'))
                    <a class="text-sm font-medium text-blue-800 hover:text-blue-900"
                        href="{{ route('password.request') }}">
                        {{ __('Forgot Password?') }}
                    </a>
                @endif
            </div>

            <!-- Action Buttons -->
            <div class="pt-2">
                <button
                    type="submit"
                    class="w-full py-3 bg-blue-900 hover:bg-blue-800 text-white rounded-lg font-semibold tracking-wide transition">
                    {{ __('Log In') }}
                </button>
            </div>

            <div class="text-center text-sm mt-3">
                <span class="text-gray-600">Not registered?</span>
                <a href="{{ route('register') }}" class="text-blue-900 font-semibold hover:underline">
                    Create an account
                </a>
            </div>
        </form>

    </div>

</x-guest-layout>
