@php
    $cid = $cid ?? 'img';
    $width = $width ?? 40;
    $height = $height ?? 40;
    $align = $align ?? 'left';
    $hspace = $hspace ?? 10;
@endphp
<img src="cid:{{ $cid }}" width="{{ $width }}" height="{{ $height }}" align="{{ $align }}" hspace="{{ $hspace }}" vspace="0"
     alt="" style="width:{{ $width }}px;height:{{ $height }}px;border:0;display:block;"/>
