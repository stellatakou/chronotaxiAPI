@extends('layouts.app')

@section('title')
    Modifier les informations - {{ $type->label }}
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h4>Modifier le type</h4>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('ridetypes.update', $type->id) }}">
            @csrf
            <input type="hidden" name="_method" value="PUT">
            <div class="modal-body">
                <div class="form-group  row"><label class="col-sm-2 col-form-label">Libellé du type</label>
                    <div class="col-sm-10"><input required type="text" name="label" value="{{ $type->label }}" class="form-control"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Sauvegarder</button>
            </div>
        </form>
    </div>
</div>
@endsection
