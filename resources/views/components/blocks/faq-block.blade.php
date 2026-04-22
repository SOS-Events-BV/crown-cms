<div class="flex flex-col gap-3 my-8">
    @foreach ($faqs as $faq)
        <x-crown-cms::faq-item :question="$faq->question" :answer="$faq->answer"/>
    @endforeach
</div>

@push('head')
    {!! $faqSchema->toScript() !!}
@endpush
