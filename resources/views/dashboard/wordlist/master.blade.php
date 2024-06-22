{{-- Wordlist Menu --}}

@extends('kerangka.wordlist');
@section('title', 'Wordlist');
@section('content')
<div class="page-content">
    <section class="row">
        <div class="col-12 col-lg-12">
            @include('include.statistic.statistic')
            {{-- @include('include.statistic.profile') --}}
    </section>
    <div class="container mt-5">
        <h2>Wordlist</h2>
        <div class="row">
            <div class="col">
                <h4>Edit Wordlist</h4>
                <form action="{{ route('wordlist.update') }}" method="POST">
                    @csrf
                    <textarea id="textarea1" class="form-control" rows="10" name="contentFromTextarea1">{{ file_get_contents(Storage::path('public/wordlist.txt')) }}</textarea>
                    <button type="submit" class="btn btn-primary mt-3">Add</button>
                </form>
            </div>
        </div>
    </div>
    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    @if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
    @endif

    @if (session('info'))
    <div class="alert alert-info">
        {{ session('info') }}
    </div>
    @endif
</div>
<!-- @include('dashboard.scan.result') -->
@endsection