<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    <style>
        table, th, td {
            border: 1px solid;
        }

        table {
            width: 100%;
        }
    </style>
</head>
<body>
     <h1>Timesheets</h1>
    {{-- {{ var_dump($timesheets) }} --}}
    <table>
  <thead>
    <tr>
      <th scope="col">ID</th>
      <th scope="col">Calendario</th>
      <th scope="col">Usuario</th>
      <th scope="col">Tipo</th>
      <th scope="col">Hora de Entrada</th>
      <th scope="col">Hora de Salida</th>
    </tr>
  </thead>
    <tbody>
        @foreach ($timesheets as $timesheet)
        {{-- cuando paso ::all() es un array --}}
    {{--         <tr>
                <td class="text-center">{{ $timesheet['id'] }}</td>
                <td class="text-center">{{ $timesheet['calendar_id'] }}</td>
                <td class="text-center">{{ $timesheet['user_id'] }}</td>
                <td class="text-center">{{ $timesheet['type'] }}</td>
                <td class="text-center">{{ $timesheet['day_in'] }}</td>
                <td class="text-center">{{ $timesheet['day_out'] }}</td>
            </tr> --}}

                {{-- cuando paso con ->get() --}}
                <tr>
                <td class="text-center">{{ $timesheet->id }}</td>
                <td class="text-center">{{ $timesheet->calendar_id }}</td>
                <td class="text-center">{{ $timesheet->user->name }}</td>
                <td class="text-center">{{ $timesheet->type }}</td>
                <td class="text-center">{{ $timesheet->day_in }}</td>
                <td class="text-center">{{ $timesheet->day_out }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
</body>
</html>