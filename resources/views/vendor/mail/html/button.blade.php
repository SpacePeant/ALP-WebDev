@props([
    'url',
    'color' => 'primary',
    'align' => 'center',
])

@php
    $backgroundColor = match ($color) {
        'primary' => '#0066cc',
        'success' => '#28a745',
        'danger' => '#dc3545',
        'warning' => '#ffc107',
        default => '#6c757d',
    };
@endphp

<table class="action" align="{{ $align }}" width="100%" cellpadding="0" cellspacing="0" role="presentation">
<tr>
<td align="{{ $align }}">
<table width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation">
<tr>
<td align="{{ $align }}">
<table border="0" cellpadding="0" cellspacing="0" role="presentation">
<tr>
<td>
<a href="{{ $url }}" target="_blank" rel="noopener"
   style="
        background-color: {{ $backgroundColor }};
        border: none;
        color: #ffffff;
        padding: 12px 24px;
        text-decoration: none;
        border-radius: 6px;
        display: inline-block;
        font-weight: 600;
        font-size: 16px;
        font-family: 'Red Hat Text', Arial, sans-serif;
        text-align: center;
   ">
    {{ $slot }}
</a>
</td>
</tr>
</table>
</td>
</tr>
</table>
</td>
</tr>
</table>
