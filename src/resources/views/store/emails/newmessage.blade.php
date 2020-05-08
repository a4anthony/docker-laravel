@php
$body = str_replace(' ','%20',$template);
@endphp

<p>Name: {{$name}}</p>
<p>Message: {{$message_content}}</p>
<a href="mailto:{{$email}}?subject=Re: {{$subject}}&body={{$body}}">Click here to reply</a>
