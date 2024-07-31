<x-mail::message>
Dear {{ $dear }},

This is a critical reminder that the student(s) you're currently mentoring <b>({{ $clients }})</b> has only 1 hour remaining of their allotted {{ $duration }}-hour meeting quota.

To ensure uninterrupted learning and support for your student, please be mindful of the time remaining.

We recommend summarizing key points and providing essential resources to maximize the remaining session.

Thank you for your dedication to your students' success.

Sincerely,<br>
{{ config('app.name') }}
</x-mail::message>
