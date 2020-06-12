<table border="5" width="500%" align="right" cellpadding="10" cellpacing="0">>
    <tr>
        <th colspan="3"><img src="public/images/LogoTD.png" /></th>
        <th colspan="3"></th>
    </tr>
    <tr>
        <th colspan="3"></th>
        <th colspan="3" style="text-align: center;font-weight:bold;">
            <h3>Pesaje Corregidos</h3>
        </th>
    </tr>
    <tr>
    </tr>
    <tr>
    </tr>
    <thead>
        <tr>
            <th colspan="3" style="text-align: center;font-weight:bold;background:#000080;color:#FFFFFF">Fecha</th>
            <th colspan="3" style="text-align: center;font-weight:bold;background:#000080;color:#FFFFFF">Patente</th>
        </tr>
    </thead>
    <tbody>
        @foreach($datos as $dato)
        <tr>
            <td colspan="3" style="text-align: center;">{{ $dato->fecha }}</td>
            <td colspan="3" style="text-align: center;">{{ $dato->patente }}</td>
        </tr>
        @endforeach
    </tbody>
</table>