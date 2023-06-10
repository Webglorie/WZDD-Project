<x-guest-layout>
    <p id="login">
        <main class="form-signin">
            <x-auth-session-status class="mb-4" :status="session('status')" />
            <h1 class="h3 mb-3 fw-bold">Wachtwoord vergeten</h1>
            <p class="mb-3">
        {{ __('Uw wachtwoord vergeten? Geen probleem. Vul uw e-mailadres in en ontvang een e-mail met een link om uw wachtwoord opnieuw in te stellen.') }}<br><br>

       {{ __('Neem contact op met de leidinggevende van de ZIT Servicedesk als het niet lukt om uw wachtwoord te herstellen.') }}
    </p>
    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-text-input  placeholder="E-mailadres" id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button class="items-center px-4 py-2 font-semibold text-white uppercase hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none transition ease-in-out duration-150 w-100 btn btn-lg btn-primary">
                {{ __('Wachtwoord reset link aanvragen') }}
            </x-primary-button>
        </div>
    </form>
        <div class="flex items-center justify-center mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                    {{ __('Terug naar het login scherm') }}
                </a>

        </div>
        </main>
    </div>
</x-guest-layout>
