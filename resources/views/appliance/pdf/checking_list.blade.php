<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <style>
            td {text-align: center;}
        </style>
    </head>
    <body>
        <h2>Date: {{$date}}</h2>
        <h2>{{$stocks->count()}} Item(s)</h2>
        <table>
            <thead>
            <tr>
                <th>
                    Model
                </th>
                <th>
                    Brand
                </th>
                <th>
                    Assign to
                </th>
                <th>
                    Shelf
                </th>
            </tr>
            </thead>
            <tbody>
            @foreach ($stocks as $stock)
                <tr>
                    <td>{{ $stock->appliance->model }}</td>
                    <td>{{ $stock->appliance->belongsToBrand->name }}</td>
                    <td>
                        @if($stock->assign_to != null)
                            {{ $stock->getAssignTo->job_id }}
                        @endif
                    </td>
                    <td>{{ $stock->shelf }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </body>
</html>
