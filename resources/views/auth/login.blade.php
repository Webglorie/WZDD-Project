<x-guest-layout>
    <div id="login">
        <main class="form-signin">

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />
            <h1 class="h3 mb-3 fw-bold">Login Beheerdashboard</h1>
            <p class="mb-3">Vul uw e-mailadres en wachtwoord in.</p>

            <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email Address -->
                <div>

                    <x-text-input placeholder="E-mailadres" id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div class="mt-4">


                    <x-text-input placeholder="Wachtwoord" id="password" class="block mt-1 w-full"
                                  type="password"
                                  name="password"
                                  required autocomplete="current-password" />

                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Remember Me -->
                <div class="block rm-block">
                    <label for="remember_me" class="inline-flex items-center">
                        <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                        <span class="ml-2 text-sm text-gray-600">{{ __('Onthoud mij') }}</span>
                    </label>
                </div>

                <x-primary-button class="w-100 btn btn-lg btn-primary">
                    {{ __('Log in') }}
                </x-primary-button>

                <div class="flex items-center justify-center mt-4">
                    @if (Route::has('password.request'))
                        <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                            {{ __('Wachtwoord vergeten?') }}
                        </a>
                    @endif

                </div>
            </form>
        </main>
    </div>
</x-guest-layout>
