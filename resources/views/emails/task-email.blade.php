@component('mail::message')
    ## Task Notification

## Hello, _{{$name}}_.
## A new task has been assigned to your account.

Project: **{{$projectName}}**<br>
Task: **{{$taskName}}**<br>
Deadline: _{{$expr}}_<br>

{{--@component('mail::button', ['url' => ''])--}}
{{--Button Text--}}
{{--@endcomponent--}}
**Thanks - Taskager team.**<br>
{{ config('app.name') }}
@endcomponent
