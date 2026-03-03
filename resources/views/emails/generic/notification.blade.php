<x-mail::message>
    # {{ $title }}

    @foreach($lines as $line)
        {{ $line }}
    @endforeach

    @if($actionText && $actionUrl)
        <x-mail::button :url="$actionUrl">
            {{ $actionText }}
        </x-mail::button>
    @endif

    Terima kasih,<br>
    {{ config('app.name') }}
</x-mail::message>