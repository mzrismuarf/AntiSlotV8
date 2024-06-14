@extends('kerangka.master')
@section('title', 'Dashboard')
@section('content')
<div class="page-heading">
    <h3>Scan Directory Statistics</h3>
</div>
<div class="page-content">
    <section class="row">
        <div class="col-12 col-lg-12">
            @include('include.statistic.statistic')
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Directory Safety Analysis</h4>
                        </div>
                        <div class="card-body">
                            @include('include.table.chart')
                        </div>
                    </div>
                </div>
                @include('include.table.data')
            </div>
        </div>
    </section>
</div>
@endsection