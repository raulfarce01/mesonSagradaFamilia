@extends('templates/baseTemplate')
@section('title', 'Mis Reservas | Mesón Sagrada Familia')
@section('main')
@include('templates/modales/modalReserva')

<section id="GestionReservasHeader" class="h-60" style="background-image: url({{ asset('img_estaticas/reservado.jpg') }}); backgroud-position: center; background-size: cover; background-repeat: no-repeat; background-origin: border-box; flex flex-col">

    <div id="headerReservas" class="w-full h-full bg-black/50 flex flex-col justify-center items-center">

        <h3 class="text-3xl text-white font-bold pt-20">Mis Reservas</h3>

    </div>

</section>

<section id="sectionReservas">

    <div id="containerReservaButon" class="flex items-center justify-end pe-5 py-4">
        <div id="abreModalReserva" class="cursor-pointer text-black bg-white rounded-full py-2 px-4 font-bold w-fit" onclick="abreModalReserva({{ Auth::user() ? Auth::user()->id : 0 }})">Reserva tu mesa</div>
    </div>

    <table id="tablaReservas" class="w-full mt-6">
        <thead>
            <th>Nombre</th>
            <th>Fecha</th>
            <th>Hora</th>
            <th>Acciones</th>
        </thead>
        <tbody id="tablaReservasBody" class="text-white">
            @if (count($reservas) > 0)
            @foreach ($reservas as $reserva)
            <tr class="h-10">
                <td class="text-center">{{ $reserva['nombre'] }}</td>
                <td class="text-center">{{ $reserva['fecha'] }}</td>
                <td class="text-center">{{ $reserva['hora'] }}</td>
                <td class="text-center">
                    <form action="{{ route('reserva_remove', $reserva['id']) }}" method="POST">
                        @csrf
                        <button type="submit" class="text-red-500">Eliminar</button>
                    </form>
                </td>
            </tr>

            @endforeach
            @endif
        </tbody>
    </table>

</section>

@endsection

@section('scripts')
<script src="{{ asset('js/index.js') }}"></script>
<script src="https://cdn.datatables.net/2.0.8/js/dataTables.js"></script>

<script>
    /*$(document).ready(function() {
        getReservasUser();
    });

    function getReservasUser() {
        $.ajax({
            url: '/getReservas/user',
            type: 'GET',
            responsive: true,
            dataType: 'json',
            success: function(response) {
                data = response.reservas.reservas;
                console.log(data);
                $('#tablaReservas').DataTable({
                    data: response.reservas,
                    'columns': [
                        { data: 'nombre' },
                        { data: 'fecha', render: function(data, type, row) {
                            let fecha = row.toDateString();
                            console.log(row);
                            console.log(fecha);
                            return fecha;
                        } },
                        { data: 'fecha' },
                        { data: null, render: function(data, type, row) {
                            return '<a href="/remove_reserva/' + row.id + '" class="btn btn-primary btn-sm">Cancelar</a>';
                        }},
                    ]
                });
            }
        });
    }*/
</script>
@endsection
