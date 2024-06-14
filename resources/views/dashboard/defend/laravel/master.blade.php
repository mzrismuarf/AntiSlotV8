{{-- Scan Menu --}}

@extends('kerangka.laravel')
@section('title', 'Laravel - Anti Slot')
@section('content')
    <div class="page-content">
        <section class="row">
            <div class="col-12 col-lg-12">
                <div class="container text-center">
                    <div class="row align-items-center justify-content-center" style="margin-bottom: 30px;">
                        <div class="col-3">
                            <a class="btn btn-primary" href="{{ route('laravel.patchcve') }}" role="button">Patch CVE
                                Laravel</a>
                        </div>
                        <div class="col-3">
                            <a class="btn btn-primary" href="{{ route('laravel.validationfile') }}"
                                role="button">Validation Upload File</a>
                        </div>
                    </div>
                </div>
                </br>
                </br>
        </section>
    </div>
@endsection
