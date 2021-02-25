@extends('layouts.app')

@section('title')
Tableau de bord
@endsection

@section('content')
<div class="row">
    <div class="col-lg-3">
        <div class="ibox ">
            <div class="ibox-title">
                <h5>Courses</h5>
            </div>
            <div class="ibox-content">
                <h1 class="no-margins">{{ $rideCount }}</h1>
                <div class="stat-percent font-bold text-navy"> <i class="fa fa-level-up"></i></div>
                <small>{{ $onGoingRides->count() }} en cours.</small>
            </div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="ibox ">
            <div class="ibox-title">
                <h5>Conducteurs</h5>
            </div>
            <div class="ibox-content">
                <h1 class="no-margins">{{ $drivers->count() }}</h1>
                <div class="stat-percent font-bold text-info"> <i class="fa fa-users"></i></div>
                <small>{{ $occupated_drivers->count() }} occupés</small>
            </div>
        </div>
    </div>

    <div class="col-lg-3">
        <div class="ibox ">
            <div class="ibox-title">
                <h5>Clients</h5>
            </div>
            <div class="ibox-content">
                <h1 class="no-margins">{{ $totalUsers }}</h1>
                <div class="stat-percent font-bold text-danger"><i class="fa fa-user"></i></div>
                <small>{{ $activeCount }} actifs.</small>
            </div>
        </div>
    </div>

    <div class="col-lg-3">
        <div class="ibox ">
            <div class="ibox-title">
                <h5>Parcours terminés</h5>
            </div>
            <div class="ibox-content">
                <h1 class="no-margins">{{ $terminatedRidesCount }}</h1>
                <div class="stat-percent font-bold text-success"><i class="fa fa-bolt"></i></div>
                <small>Total</small>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="ibox ">
            <div class="ibox-title">
                <h5>User project list</h5>
                <div class="ibox-tools">
                    <a class="collapse-link">
                        <i class="fa fa-chevron-up"></i>
                    </a>
                    <a class="close-link">
                        <i class="fa fa-times"></i>
                    </a>
                </div>
            </div>
            <div class="ibox-content table-responsive">
                <table class="table table-hover no-margins">
                    <thead>
                        <tr>
                            <th>Statut</th>
                            <th>Client</th>
                            <th>Conducteur</th>
                            <th>Distance</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($rides as $r)
                        <tr>
                            <td><small><span
                                        class="label label-{{ App\Helpers\Helper::getStatusColor($r->status->code) }}">{{ $r->status->label }}</span></small>
                            </td>
                            <td>{{ $r->client->name }}</td>
                            <td>{{ $r->driver->name ?? "-/-" }}</td>
                            <td class="text-navy"> <i class="fa fa-level-up"></i>
                                {{ round(App\Helpers\Helper::getDistance($r->latitude, $r->longitude, $r->toLatitude, $r->toLongitude)['meters']) }}
                                m</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="m-t-md">
            <h4>Meilleures destinations</h4>
            <div>
                <ul class="list-group">
                    @forelse($mostCommonRide as $key=>$m)
                    <li class="list-group-item">
                        <span class="badge badge-{{ App\Helpers\Helper::getRankcolor($key+1) }}">{{ $key+1 }}</span>
                         {{ $m->to }}
                    </li>
                    @empty
                    <li class="list-group-item ">
                        Aucune information à afficher.
                    </li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
