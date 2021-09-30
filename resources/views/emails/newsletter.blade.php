@component('mail::message')

    {!! $newsletter->content !!}



Thanks,<br>
{{ config('app.name') }}
@endcomponent
@if($newsletterRecipient)
    <div style="display: none"><img src="{{ env('APP_URL')}}/newsletter/tracking/{{$newsletterRecipient->uuid}}.jpg"></div>
@endif