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
        <h2>Sum: {{$total}} Item(s)</h2>
        <table>
            <thead>
            <tr>
                <th>
                    Quantity
                </th>
                <th>
                    Model
                </th>
                <th>
                    Brand
                </th>
                <th>
                    Category
                </th>
                <th>
                    Best Price
                </th>
                <th>
                    Description
                </th>
            </tr>
            </thead>
            <tbody>
            @foreach ($stocks as $stock)
                <tr>
                    <td>{{ $stock->total }}</td>
                    <td>{{ $stock->appliance->model }}</td>
                    <td>{{ $stock->appliance->belongsToBrand->name }}</td>
                    <td>{{ $stock->appliance->belongsToCategory->name }}</td>
                    <td>{{ $stock->appliance->best }}</td>
                    <td>{{ $stock->appliance->description }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </body>
</html>
