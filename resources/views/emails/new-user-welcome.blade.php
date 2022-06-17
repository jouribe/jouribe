@component('mail::message')
# Introduction

Hello {{ $user->name }}!

@component('mail::button', ['url' => ''])
Button Text
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
