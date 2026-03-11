<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2 bg-mzl-blue border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-mzl-blue/90 focus:bg-mzl-blue/90 active:bg-mzl-blue focus:outline-none focus:ring-2 focus:ring-mzl-blue focus:ring-offset-2 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
