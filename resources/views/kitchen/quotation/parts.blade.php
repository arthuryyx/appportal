<div class="row">
    @foreach($parts as $part)
    <div class="col-lg-3">
        <strong>{{$part->name}}:</strong>
        <br/>
        {{ Form::select('materials['.$part->id.'][mid]', $data[$part->id], null, ['class' => 'form-control', 'placeholder'=>'Select', 'required' => 'required']) }}
        {{ Form::hidden('materials['.$part->id.'][qty]', $part->pivot->qty) }}
    </div>
@endforeach
</div>
{{Form::submit('Submit', ['class' => 'btn  add-more btn-success pull-right'])}}
