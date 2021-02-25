@extends('layouts.app')

@section('title')
    Types de trajets
@endsection

@section('action')
<button class="btn btn-primary" data-toggle="modal" data-target="#createModal"><i class="fa fa-plus"></i> Nouveau
    type</button>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h4>Tous les types</h4>
    </div>
    <div class="card-body">
        @if($types->count() == 0)
        <p class="alert alert-warning">Aucun type enregistré.</p>
        @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Libellé</th>
                    <th scope="col">Options</th>
                </tr>
            </thead>
            <tbody>
                @foreach($types as $type)
                <tr>
                    <td>{{ $type->id }}</td>
                    <td>{{ $type->label }}</td>
                    <td class="text-center">
                        <!--<a href="{{ route('ridetypes.show', $type->id) }}" class="btn btn-sm btn-outline btn-primary"
                            data-toggle="tooltip" data-placement="top" title=""
                            data-original-title="Consulter les informations du conducteur"><i class="fa fa-eye"></i></a>-->
                        <a href="{{ route('ridetypes.edit', $type->id) }}" class="btn btn-sm btn-outline btn-warning"
                            data-toggle="tooltip" data-placement="top" title=""
                            data-original-title="Modifier les informations du conducteur."><i
                                class="fa fa-edit"></i></a>
                        <form action="{{ route('ridetypes.destroy', $type->id) }}" class="deleteForm"
                            style="display: inline;" method="POST">
                            @csrf
                            <input type="hidden" name="_method" value="DELETE">
                            <button class="btn btn-sm btn-outline btn-danger deleteBtn" data-toggle="tooltip" data-placement="top"
                                title="" data-original-title="Supprimer le conducteur"><i class="fa fa-trash"></i>
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
                <i class="fa fa-road modal-icon"></i>
                <h4 class="modal-title">Nouveau type de trajet</h4>
                <small class="font-bold">Ajouter un nouveau type de trajet à la plateforme</small>
            </div>
            <form method="POST" action="{{ route('ridetypes.store') }}">
                @csrf
                <div class="modal-body">
                    <div class="form-group  row"><label class="col-sm-2 col-form-label">Libellé</label>
                        <div class="col-sm-10"><input required type="text" name="label" class="form-control"></div>
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
