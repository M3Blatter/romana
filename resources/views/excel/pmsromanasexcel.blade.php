<table border="5" width="500%" align="right" cellpadding="10" cellpacing="0">
    <tr>
        <th colspan="3"><img src="public/images/LogoTD.png" /></th>
        <th colspan="3"></th>
        <th colspan="3"></th>
        <th colspan="3"></th>
        <th colspan="3"></th>
    </tr>
    <tr>
        <td colspan="3"></td>
        <td colspan="3"></td>
        <th colspan="3" style="text-align: center;font-weight:bold;">
            <h3>Pesaje con Sobrepeso</h3>
        </th>
        <th colspan="3"></th>
        <th colspan="3"></th>
    </tr>
    <tr>
    </tr>
    <tr>
    </tr>
    <thead>
        <tr>
            <th colspan="3" style="text-align: center;font-weight:bold;background:#000080;color:#FFFFFF">Fecha Entrada</th>
            <th colspan="3" style="text-align: center;font-weight:bold;background:#000080;color:#FFFFFF">Patente</th>
            <th colspan="3" style="text-align: center;font-weight:bold;background:#000080;color:#FFFFFF">Peso Bruto</th>
            <th colspan="3" style="text-align: center;font-weight:bold;background:#000080;color:#FFFFFF">Peso Maximo</th>
            <th colspan="3" style="text-align: center;font-weight:bold;background:#000080;color:#FFFFFF">Sobrepeso</th>
        </tr>
    </thead>
    <tbody>
        @foreach($datos as $dato)
        <tr>
            <td colspan="3" style="text-align: center;">{{ $dato->fe_ent }}</td>
            <td colspan="3" style="text-align: center;">{{ $dato->patente }}</td>
            <td colspan="3" style="text-align: center;">{{ $dato->bruto }}</td>
            <td colspan="3" style="text-align: center;">{{ $dato->maximo }}</td>
            <td colspan="3" style="text-align: center;">{{ $dato->sobrepeso }}</td>
        </tr>
        @endforeach
    </tbody>
</table>