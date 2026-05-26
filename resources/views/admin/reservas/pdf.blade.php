<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Comprobante de Reserva #{{ $reserva->id }}</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            color: #333;
            line-height: 1.4;
        }
        .invoice-box {
            max-width: 800px;
            margin: auto;
            padding: 30px;
            border: 1px solid #eee;
        }
        .header-table {
            width: 100%;
            margin-bottom: 30px;
        }
        .logo-title {
            font-size: 26px;
            font-weight: bold;
            color: #212529;
        }
        .reserva-id {
            text-align: right;
            font-size: 18px;
            color: #666;
        }
        .section-title {
            background: #f8f9fa;
            font-weight: bold;
            padding: 8px;
            margin-top: 20px;
            border-bottom: 2px solid #dee2e6;
            text-transform: uppercase;
            font-size: 13px;
            color: #495057;
        }
        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 5px;
        }
        .info-table td {
            padding: 8px 10px;
            border-bottom: 1px solid #eee;
            font-size: 14px;
        }
        .info-table td.label {
            font-weight: bold;
            color: #555;
            width: 30%;
        }
        .total-box {
            text-align: right;
            margin-top: 30px;
            font-size: 20px;
            font-weight: bold;
        }
        .total-price {
            color: #198754; /* Verde text-success de tu vista */
        }
        .footer-text {
            text-align: center;
            margin-top: 40px;
            font-size: 12px;
            color: #999;
        }
    </style>
</head>
<body>

    <div class="invoice-box">
        <table class="header-table">
            <tr>
                <td style="width: 60%; vertical-align: middle;">
                    @if($logoBase64)
                        <img src="{{ $logoBase64 }}" alt="Logo" style="width: 40px; height: 40px; margin-right: 10px; vertical-align: middle;">
                    @endif
                    <span class="logo-title" style="vertical-align: middle;">PILLA TU CANCHA</span>
                </td>
                <td class="reserva-id" style="width: 40%; text-align: right; vertical-align: middle;">
                    Comprobante de Reserva: <strong>#{{ $reserva->id }}</strong>
                </td>
            </tr>
        </table>

        <div class="section-title">Información del Usuario</div>
        <table class="info-table">
            <tr>
                <td class="label">Nombre:</td>
                <td>{{ $usuario->nombre }}</td>
            </tr>
            <tr>
                <td class="label">Teléfono:</td>
                <td>{{ $usuario->numero }}</td>
            </tr>
            <tr>
                <td class="label">Documento:</td>
                <td>{{ $usuario->documento }}</td>
            </tr>
        </table>

        <div class="section-title">Detalles de la Cancha</div>
        <table class="info-table">
            <tr>
                <td class="label">Cancha:</td>
                <td>{{ $cancha->nombre }}</td>
            </tr>
            <tr>
                <td class="label">Dirección:</td>
                <td>{{ $cancha->direccion }}</td>
            </tr>
        </table>

        <div class="section-title">Detalles del Turno</div>
        <table class="info-table">
            <tr>
                <td class="label">Fecha del Partido:</td>
                <td>{{ \Carbon\Carbon::parse($reserva->fecha)->format('d/m/Y') }}</td>
            </tr>
            <tr>
                <td class="label">Horario Reservado:</td>
                <td>{{ $horario->hora_inicio }} - {{ $horario->hora_fin }}</td>
            </tr>
            <tr>
                <td class="label">Cantidad de Jugadores:</td>
                <td>{{ $reserva->cantidad_jugadores }}</td>
            </tr>
            <tr>
                <td class="label">Estado de Reserva:</td>
                <td>
                    <strong>
                        @if($reserva->estado == 'confirmada')
                            Confirmada
                        @elseif($reserva->estado == 'cancelada')
                            Cancelada
                        @else
                            {{ ucfirst($reserva->estado) }}
                        @endif
                    </strong>
                </td>
            </tr>
        </table>

        <div class="total-box">
            Total Pagado: <span class="total-price">${{ number_format($horario->precio, 0, ',', '.') }}</span>
        </div>

        <div class="footer-text">
            Gracias por usar Pilla Tu Cancha. ¡Disfruta el partido! <br>
            Documento generado automáticamente en pillatucancha.duckdns.org
        </div>
    </div>

</body>
</html>