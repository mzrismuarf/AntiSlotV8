{{-- Scan Menu --}}

@extends('kerangka.wordpress')
@section('title', 'Wordpress - Anti Slot')
@section('content')
    <div class="page-content">
        <section class="row">
            <div class="col-12 col-lg-12">
                {{-- @include('include.statistic.statistic') --}}
                {{-- <h1 style="text-align: center; margin: 30px 50px;">Menu Anti Slot - Wordpress</h1> --}}
                <div class="container text-center">
                    <div class="row align-items-center justify-content-center" style="margin-bottom: 30px;">
                        <div class="col-3">
                            <a class="btn btn-primary" href="{{ route('xmlrpc') }}" role="button">Disable
                                XMLRPC</a>
                        </div>
                        <div class="col-3">
                            <a class="btn btn-primary" href="{{ route('defend.wp.disablefile') }}" role="button">Disable
                                File Modification</a>
                        </div>
                    </div>
                </div>
                </br>
                </br>
        </section>
    </div>
@endsection
