<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title></title>
</head>
<body>
    <table>
        <thead>
            <th>Català</th>
            <th>Castellano</th>
            <th>Canvios</th>
        </thead>
        <tbody>
            @for ($i = 0; $i < count($english); $i++)
                <tr>
                    <td>{{ $catalan[$i] }}</td>
                    <td>{{ $spanish[$i] }}</td>
                    <td></td>
                </tr>
            @endfor
        </tbody>
    </table>

</body>
</html>