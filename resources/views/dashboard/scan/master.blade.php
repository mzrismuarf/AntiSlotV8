{{-- Scan Menu --}}

@extends('kerangka.scan');
@section('title', 'Scan');
@section('content')
    <div class="page-content">
        <section class="row">
            <div class="col-12 col-lg-12">
                @include('include.statistic.statistic')
                {{-- @include('include.statistic.profile') --}}
        </section>
        <div class="container mt-5">
            <h2>File Scanner</h2>
            <form action="{{ url('/file-scanner/scan') }}" method="post">
                @csrf
                <div class="form-group">
                    <label for="wordlist_type">Choose Wordlist:</label>
                    <select class="form-control" id="wordlist_type" name="wordlist_type">
                        <option value="slot">Slot (Default)</option>
                        <option value="best_wordlist_slot">Best Wordlist Slot</option>                        
                    </select>
                </div>
                <div class="form-group">
                    <label for="directory">Directory Path:</label>
                    <input type="text" class="form-control" id="directory" name="directory" placeholder="Enter directory path">
                </div>
                <button type="submit" class="btn btn-primary">Scan</button>
            </form>
        </div>
        @include('dashboard.scan.result')
    @endsection
