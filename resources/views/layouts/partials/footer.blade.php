<div class="relative text-white py-8 footer">
    <img class="w-7 absolute left-60 top-32 transform -translate-x-1/2" src="{{ Storage::url('web-images/quran-nexus-logo-image.png') }}" alt="Quran Nexus Logo Image">
    <div class="container mx-auto absolute left-96 top-32 w-2/3">
        <div class="grid grid-cols-3 gap-2 mt-4">
            <p class="font-bold mx-5 text-[#75FF9C]">{{ __('footer.create_free_account') }}</p>
            <p class="font-bold mx-5 text-[#75FF9C]">{{ __('footer.services') }}</p>
            <p class="font-bold mx-5 text-[#75FF9C]">{{ __('footer.support') }}</p>
        </div>
        <div class="grid grid-cols-3 gap-2 mt-4">
            <a class="font-bold mx-5 text-white" href="{{ route('login') }}">{{ __('footer.sign_in') }}</a>
            <a class="font-bold mx-5 text-white" href="{{ route('quran_analysis.show') }}">{{ __('footer.quran_analysis') }}</a>
            <a class="font-bold mx-5 text-white" href="{{ route('contact') }}">{{ __('footer.contact_us') }}</a>
        </div>
        <div class="grid grid-cols-3 gap-2 mt-4">
            <a class="font-bold mx-5 text-white" href="{{ route('register') }}">{{ __('footer.register') }}</a>
            <a class="font-bold mx-5 text-white" href="{{ route('api_documentation.index') }}">{{ __('footer.documentation') }}</a>
            <a class="font-bold mx-5 text-white" href="{{ route('faqs') }}">{{ __('footer.faqs') }}</a>
        </div>
    </div>
    <div class="footer-copyright mt-12 absolute bottom-0 left-0 right-0 border-t-2 border-[#86D6C3] flex ps-52 items-center">
            <p class="text-white mx-4 flex items-center font-serif me-7 font-bold">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-c-circle me-2" viewBox="0 0 16 16">
                    <path d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8m15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0M8.146 4.992c-1.212 0-1.927.92-1.927 2.502v1.06c0 1.571.703 2.462 1.927 2.462.979 0 1.641-.586 1.729-1.418h1.295v.093c-.1 1.448-1.354 2.467-3.03 2.467-2.091 0-3.269-1.336-3.269-3.603V7.482c0-2.261 1.201-3.638 3.27-3.638 1.681 0 2.935 1.054 3.029 2.572v.088H9.875c-.088-.879-.768-1.512-1.729-1.512"/>
                </svg>
                {{ __('footer.copyright_quran_nexus') }}
            </p>
            <a class="text-white mx-4 font-serif me-7 font-bold" href="{{route('terms.show')}}">
                {{ __('footer.copyright_terms') }}
            </a>
            <a class="text-white mx-4 font-serif font-bold" href="{{route('policy.show')}}">
                {{ __('footer.copyright_policy') }}
            </a>
    </div>
</div>
