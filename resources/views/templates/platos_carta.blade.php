@extends('templates/baseTemplate')
@section('title', 'Carta | Mesón Sagrada Familia')
@section('main')

<section id="portada" style="background-image: url({{ asset('img_estaticas/portadaCarta.png') }}); backgroud-position: center; background-size: cover; background-repeat: no-repeat; background-origin: border-box; flex flex-col justifybetween" class="w-full h-96">
    <div id="contenedorPortada" class="h-full w-full bg-black/30 flex flex-col justify-center items-center text-white gap-3 pt-32">
        <h1 class="font-bold md:text-5xl text-3xl">Nuestra Carta</h1>
    </div>
</section>

<section id="platos" class="grid grid-cols-2 md:grid-cols-4 gap-5">

    <div id="topPlatos" class="w-full h-full md:col-span-4 col-span-2">

    </div>

</section>

@endsection
