<x-mail::message>
# Introduction

The body of your message.

<x-mail::button :url="''">
{{ $token }}
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
