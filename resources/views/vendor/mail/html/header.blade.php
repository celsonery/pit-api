@props(['url'])
<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
{{--@if (trim($slot) === 'Laravel')--}}
{{--<img src="https://laravel.com/img/notification-logo.png" class="logo" alt="Laravel Logo">--}}
<img src="https://api-pit.oregon.net.br/storage/images/coffee.png" class="logo" alt="Café gourmet logo">
{{--@else--}}
{{--{{ $slot }}--}}
{{--@endif--}}
</a>
</td>
</tr>
