@extends('layouts.app')

@section('title')
Tous les utilisateurs
@endsection

@section('action')
<button class="btn btn-primary" data-toggle="modal" data-target="#createModal"><i class="fa fa-plus"></i> Nouvel
    utilisateur</button>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h4>Tous les utilisateurs</h4>
    </div>
    <div class="card-body">
        @if($users->count() == 0)
        <p class="alert alert-warning">Aucun utilisateur enregistré.</p>
        @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nom</th>
                    <th scope="col">Email</th>
                    <th scope="col">Téléphone</th>
                    <th scope="col">Bloqué</th>
                    <th scope="col">Options</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{!! $user->phone ?? "<em>Non défini</em>" !!}</td>
                    <td class="text-center">
                        <span class="badge {{ !$user->activated ? "badge-danger" : "badge-success" }}">
                            {{ !$user->activated ? "Oui" : "Non" }}
                        </span>
                    </td>
                    <td class="text-center">
                        <!--href="{{ route('users.show', $user->id) }}"-->
                        <a href="#" class="btn btn-sm btn-outline btn-primary"
                            data-toggle="tooltip" data-placement="top" title=""
                            data-original-title="Consulter les informations du utilisateur"><i class="fa fa-eye"></i></a>
                        <!--<a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm btn-outline btn-warning"
                            data-toggle="tooltip" data-placement="top" title=""
                            data-original-title="Modifier les informations du utilisateur."><i
                                class="fa fa-edit"></i></a>-->
                        <form action="{{ route('users.destroy', $user->id) }}" class="deleteForm"
                            style="display: inline;" method="POST">
                            @csrf
                            <input type="hidden" name="_method" value="DELETE">
                            <button class="btn btn-sm btn-outline btn-danger deleteBtn" data-toggle="tooltip" data-placement="top"
                                title="" data-original-title="Supprimer le utilisateur"><i class="fa fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach

            </tbody>
        </table>
        @endif
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createModalTitle"
    aria-hidden="true">
    <div class="modal-dialog inmodal modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Fermer</span></button>
                <i class="fa fa-user modal-icon"></i>
                <h4 class="modal-title">Nouvel administrateur</h4>
                <small class="font-bold">Ajouter un nouvel administrateur à la plateforme</small>
            </div>
            <form method="POST" action="{{ route('users.store') }}">
                @csrf
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
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                    <button type="submit" class="btn btn-primary">Sauvegarder</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('script')
<script>
    $('.table').DataTable()
    $('.deleteBtn').on("click", function (e) {
        e.preventDefault()
        var form = $(this).closest("form")
        Swal.fire({
            title: 'Êtes-vous sûr ?',
            text: 'La suppression de cet élément est irréversible!',
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Oui',
            cancelButtonText: 'Non'
        }).then((result) => {
            if (result.value) {
                form.submit();
            }
        })
    })
</script>
@endsection
