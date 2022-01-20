<footer class="footer mt-auto d-block" id="footer">
    <div class="w-100 py-2 d-flex justify-content-between align-items-center">
        <div class="d-inline-flex align-items-center">
            @Bright Events 2021
        </div>
        <div class="p-0 d-inline-flex justify-content-end">
            <a class="btn" href="{{ route('contacts') }}">
                <h2 class="d-flex flex-no-wrap">Contact Us</h2>
            </a>
            <a class="btn" href="{{ route('faq') }}">
                <h2>FAQ</h2>
            </a>
            <a class="btn" href="{{ route('about') }}">
                <h2>About</h2>
            </a>
        </div>
    </div>
</footer>

@yield('footer')
