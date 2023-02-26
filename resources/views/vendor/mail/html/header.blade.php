@props(['url'])
<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'AlphaOmega')
<img src="https://res.cloudinary.com/dvegxoufp/image/upload/v1677120659/Imagenes/326503893_490978166570841_7047864990073243512_n_w9mrcd.png" class="logo" alt="Laravel Logo">
@else
{{ $slot }}
@endif
</a>
</td>
</tr>
