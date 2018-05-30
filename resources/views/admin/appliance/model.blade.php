<thead>
<tr>
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
        description
    </th>
    <th>
        State
    </th>
</tr>
</thead>
<tbody>
<tr>
    <td>{{$model->model}}</td>
    <td>{{$model->belongsToBrand->name}}</td>
    <td>{{$model->belongsToCategory->name}}</td>
    <td>{{$model->description}}</td>
    <td>
        @if($model->state)
            <label class="label label-danger">Discontinued</label>
        @else
            <label class="label label-success">In Use</label>
        @endif
    </td>
</tr>
</tbody>
<thead>
<tr>
    <th>
        RRP
    </th>
    <th>
        lv1 price
    </th>
    <th>
        lv2 price
    </th>
    <th>
        lv3 price
    </th>
    <th>
        lv4 price
    </th>
</tr>
</thead>
<tbody>
<tr>
    <td>{{$model->rrp}}</td>
    <td>{{$model->lv1}}</td>
    <td>{{$model->lv2}}</td>
    <td>{{$model->lv3}}</td>
    <td>{{$model->lv4}}</td>
</tr>
</tbody>