<x-mail::message>
# New contact was shared with you

User {{ $fromUser }} shared contact {{ $sharedContact }} with you.


<x-mail::button url="'route('contact-shares.index')'">
See Here
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
