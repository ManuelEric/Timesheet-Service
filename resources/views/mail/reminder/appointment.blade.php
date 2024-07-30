<x-mail::message>
# Reminder

Dear {{ $dear }},

This is a friendly reminder about your {{ $program_category }} session with {{ $clients }} tomorrow, {{ $activity['date'] }} at {{ $activity['time'] }}. 
The session will be held online <a href="{{ $activity['link'] }}">here</a>.

Looking forward to a productive session!

Best regards,<br>
{{ config('app.name') }}
</x-mail::message>
