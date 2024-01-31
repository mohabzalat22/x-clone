<x-mail::message>
{{$user->name}} has followed you.
<x-mail::button :url="$url" color="green">
Follow back
</x-mail::button>
 
{{ config('app.name') }}
</x-mail::message>