@extends('layouts.app')

@section('title')
{{ $driver->name }}
@endsection

@section('content')
<div class="row m-b-lg m-t-lg">
    <div class="col-md-6">

        <div class="profile-image">
            <img src="{{ $driver->avatar }}" class="rounded-circle circle-border m-b-md" alt="profile">
        </div>
        <div class="profile-info">
            <div class="">
                <div>
                    <h2 class="no-margins">
                        {{ $driver->name }}
                    </h2>
                    <h4>{{ $driver->role->label }}</h4>
                    <small>
                        {{ $driver->bio }}
                    </small>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <table class="table small m-b-xs">
            <tbody>
                <tr>
                    <td>
                        <strong>{{ $driver->rides->count() }}</strong> Client satisfaits
                    </td>
                    <td>
                        <strong>{{ $driver->reviews->count() }}</strong> Notes
                    </td>

                </tr>
            </tbody>
        </table>
    </div>
    <div class="col-md-3">
        <small>Note moyenne</small>
        <h2 class="no-margins">{{ $driver->reviews->count() > 0 ? $driver->reviews->avg("note") ."/5" : "Aucune note" }}
        </h2>
        <div id="sparkline1"></div>
    </div>


</div>
<div class="row">

    <div class="col-lg-4">

        <div class="ibox">
            <div class="ibox-content">
                <h3>A Propos</h3>

                <p class="small">
                    {{ $driver->bio ?? "Aucun information supplémentaire." }}
                </p>
            </div>
        </div>

    </div>

    <div class="col-lg-8">
        <div class="tabs-container">
            <ul class="nav nav-tabs">
                <li><a class="nav-link active" data-toggle="tab" href="#tab-3"> <i class="fa fa-road"></i></a></li>
                <li><a class="nav-link" data-toggle="tab" href="#tab-4"><i class="fa fa-comment"></i></a></li>
                <li><a class="nav-link" data-toggle="tab" href="#tab-5"><i class="fa fa-phone"></i></a></li>
            </ul>
            <div class="tab-content">
                <div id="tab-3" class="tab-pane active">
                    <div class="panel-body">
                        <div class="ibox ">


                            <p class="m-b-lg">
                                <b>Tous les trajets effectués par le conducteur</b>
                                <span class="pull-right">Total ({{ $driver->rides->count() }})</span>
                            </p>

                            <div class="dd" id="nestable2">
                                <ol class="dd-list">
                                    <li class="dd-item" data-id="1"><button data-action="collapse"
                                            type="button">Collapse</button><button data-action="expand" type="button"
                                            style="display: none;">Expand</button>
                                        <div class="dd-handle">
                                            <span class="label label-info"><i class="fa fa-users"></i></span> Cras
                                            ornare tristique.
                                        </div>
                                        <ol class="dd-list">
                                            <li class="dd-item" data-id="2">
                                                <div class="dd-handle">
                                                    <span class="float-right"> 12:00 pm </span>
                                                    <span class="label label-info"><i class="fa fa-cog"></i></span>
                                                    Vivamus vestibulum nulla nec ante.
                                                </div>
                                            </li>
                                            <li class="dd-item" data-id="3">
                                                <div class="dd-handle">
                                                    <span class="float-right"> 11:00 pm </span>
                                                    <span class="label label-info"><i class="fa fa-bolt"></i></span>
                                                    Nunc dignissim risus id metus.
                                                </div>
                                            </li>
                                            <li class="dd-item" data-id="4">
                                                <div class="dd-handle">
                                                    <span class="float-right"> 11:00 pm </span>
                                                    <span class="label label-info"><i class="fa fa-laptop"></i></span>
                                                    Vestibulum commodo
                                                </div>
                                            </li>
                                        </ol>
                                    </li>

                                    <li class="dd-item" data-id="5"><button data-action="collapse"
                                            type="button">Collapse</button><button data-action="expand" type="button"
                                            style="display: none;">Expand</button>
                                        <div class="dd-handle">
                                            <span class="label label-warning"><i class="fa fa-users"></i></span>
                                            Integer vitae libero.
                                        </div>
                                        <ol class="dd-list">
                                            <li class="dd-item" data-id="6">
                                                <div class="dd-handle">
                                                    <span class="float-right"> 15:00 pm </span>
                                                    <span class="label label-warning"><i class="fa fa-users"></i></span>
                                                    Nam convallis
                                                    pellentesque nisl.
                                                </div>
                                            </li>
                                            <li class="dd-item" data-id="7">
                                                <div class="dd-handle">
                                                    <span class="float-right"> 16:00 pm </span>
                                                    <span class="label label-warning"><i class="fa fa-bomb"></i></span>
                                                    Vivamus molestie gravida
                                                    turpis
                                                </div>
                                            </li>
                                            <li class="dd-item" data-id="8">
                                                <div class="dd-handle">
                                                    <span class="float-right"> 21:00 pm </span>
                                                    <span class="label label-warning"><i class="fa fa-child"></i></span>
                                                    Ut aliquam sollicitudin
                                                    leo.
                                                </div>
                                            </li>
                                        </ol>
                                    </li>
                                </ol>


                            </div>

                        </div>
                    </div>
                </div>
                <div id="tab-4" class="tab-pane">
                    <div class="panel-body">
                        @forelse ($driver->reviews as $review)
                        <div class="social-feed-box">
                            <div class="float-right social-action dropdown">
                                <b>{{ $review->note }}/5</b>
                            </div>
                            <div class="social-avatar">
                                <a href="" class="float-left">
                                    <img alt="image" src="{{ $review->client->avatar }}" />
                                </a>
                                <div class="media-body">
                                    <a href="#">
                                        {{ $review->client->name }}
                                    </a>
                                    <small class="text-muted">{{ $review->created_at }}</small>
                                </div>
                            </div>
                            <div class="social-body">
                                <p>
                                    {{ $review->body }}
                                </p>
                            </div>
                        </div>
                        @empty
                        <p class="alert alert-warning">Aucune note pour ce conducteur.</p>
                        @endforelse
                    </div>
                </div>
                <div id="tab-5" class="tab-pane">
                    <div class="panel-body">
                        <div class="widget lazur-bg p-xl">

                            <h2>
                                {{ $driver->name }}
                            </h2>
                            <ul class="list-unstyled m-t-md">
                                <li>
                                    <span class="fa fa-envelope m-r-xs"></span>
                                    <label>Email:</label>
                                    {{ $driver->email }}
                                </li>
                                <li>
                                    <span class="fa fa-home m-r-xs"></span>
                                    <label>Address:</label>
                                    {{ $driver->address }}
                                </li>
                                <li>
                                    <span class="fa fa-phone m-r-xs"></span>
                                    <label>Contact:</label>
                                    {{ $driver->phone }}
                                </li>
                            </ul>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
