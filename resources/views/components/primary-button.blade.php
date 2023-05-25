<button {{ $attributes->merge(['type' => 'submit', 'class' => 'items-center px-4 py-2 font-semibold text-white uppercase hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
