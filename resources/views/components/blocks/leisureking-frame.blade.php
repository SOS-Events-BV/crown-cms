<iframe src="{{ $url }}" id="lk-booking-window"
        title="booking-window" loading="lazy" style="width:100%">
    <p>Your browser does not support iframes.<br>
        <a href="{{ $url }}" target="_blank">Open venster in nieuw
            tabblad</a></p>
</iframe>

@push('scripts')
    <script type="text/javascript" src="https://booking.leisureking.eu/bm/scale.js"></script>
@endpush
