@extends('layouts.app')

@section('title')
Modifier les informations - {{ $driver->name }}
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h4>Modifier les informations du conducteur</h4>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('drivers.update', $driver->id) }}">
            @csrf
            <input type="hidden" name="_method" value="PUT">
            <div class="modal-body">
                <div class="form-group  row"><label class="col-sm-2 col-form-label">Nom complet</label>
                    <div class="col-sm-10"><input required type="text" name="name" class="form-control"></div>
                </div>
                <div class="form-group  row"><label class="col-sm-2 col-form-label">Email</label>
                    <div class="col-sm-10"><input type="email" required name="email" class="form-control"></div>
                </div>

                <div class="form-group  row"><label class="col-sm-2 col-form-label">Adresse</label>
                    <div class="col-sm-10"><input required type="text" name="address" class="form-control"></div>
                </div>

                <div class="form-group  row"><label class="col-sm-2 col-form-label">Téléphone</label>
                    <div class="col-sm-10"><input type="number" required name="phone" class="form-control"></div>
                </div>

                <div class="form-group  row"><label class="col-sm-2 col-form-label">Date de naissance</label>
                    <div class="col-sm-10"><input type="date" required name="birthdate" class="form-control"></div>
                </div>
                <div class="form-group  row"><label class="col-sm-2 col-form-label">Marque du véhicule</label>
                    <div class="col-sm-10"><input type="text" required name="carmark" class="form-control"></div>
                </div>
                <div class="form-group  row"><label class="col-sm-2 col-form-label">Model du véhicule</label>
                    <div class="col-sm-10"><input type="text" required name="carmodel" class="form-control"></div>
                </div>
                <div class="form-group  row"><label class="col-sm-2 col-form-label">Type de voiture</label>
                    <div class="col-sm-10"><input type="text" required name="cartype" class="form-control"></div>
                </div>
                <div class="form-group  row"><label class="col-sm-2 col-form-label">Immatriculation</label>
                    <div class="col-sm-10"><input type="text" required name="registration" class="form-control"></div>
                </div>
                <div class="form-group  row"><label class="col-sm-2 col-form-label">No de chassis</label>
                    <div class="col-sm-10"><input type="date" required name="chassisnumber" class="form-control"></div>
                </div>
                <div class="form-group  row"><label class="col-sm-2 col-form-label">Nombre de place</label>
                    <div class="col-sm-10"><input type="number" required name="place" class="form-control"></div>
                </div>
                <div class="form-group  row"><label class="col-sm-2 col-form-label">Permis de conduire</label>
                    <div class="col-sm-10"><input type="date" required name="driverlicence" class="form-control"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                <button type="submit" class="btn btn-primary">Sauvegarder</button>
            </div>
        </form>
    </div>
</div>
@endsection
