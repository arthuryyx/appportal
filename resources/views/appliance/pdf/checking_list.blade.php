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
        <h2>{{$stocks->sum('total')}} Item(s)</h2>
        <h2>
	        ${{ $stocks->sum(function ($stock) {
	    		return $stock->appliance->rrp?($stock->appliance->rrp*$stock->total):0;
		}) }}
	</h2>
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
                    RRP
                </th>
            </tr>
            </thead>
            <tbody>
            @foreach ($stocks->sortBy('appliance.model') as $stock)
                <tr>
                    <td>{{ $stock->total }}</td>
                    <td>{{ $stock->appliance->model }}</td>
                    <td>{{ $stock->appliance->belongsToBrand->name }}</td>
                    <td>
                    	{{ $stock->appliance->rrp}}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </body>
</html>
