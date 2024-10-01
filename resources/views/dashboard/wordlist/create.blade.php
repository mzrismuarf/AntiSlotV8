{{-- Wordlist Menu --}}

@extends('kerangka.wordlist');
@section('title', 'Wordlist');
@section('content')
<div class="page-content">
    <div class="container mt-5">
        <h2>Wordlist</h2>
        <div class="row">
    <!-- Basic Tables start -->
    <section class="section">
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
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Tambah Wordlists</h5>
            </div>
            <div class="card-body">
                <h2>Tambah Wordlist</h2>

                <!-- Form untuk menambah wordlist secara manual -->
                <form action="{{ route('wordlist.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="best_wordlist_slot">Best Wordlist Slot</label>
                        <input type="text" class="form-control" name="best_wordlist_slot">
                    </div>
                    <div class="form-group">
                        <label for="slot">Slot</label>
                        <input type="text" class="form-control" name="slot">
                    </div>
                    <div class="form-group">
                        <label for="backdoor">Backdoor</label>
                        <input type="text" class="form-control" name="backdoor">
                    </div>
            
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <a href="javascript:history.back()" class="btn btn-secondary">Cancel</a>
                </form>
            
                <hr>
            
                <!-- form untuk upload wordlist dari file Excel -->
                <h4>Upload Wordlist dari Excel</h4>
                <form action="{{ route('wordlist.upload') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="file">Pilih file Excel</label>
                        <input type="file" class="form-control" name="file" accept=".xls,.xlsx" required>
                    </div>
                    <button type="submit" class="btn btn-success">Upload</button>
                </form>
            </div>
    </section>
    <!-- Basic Tables end -->
        </div>
    </div>
</div>
<!-- @include('dashboard.scan.result') -->
@endsection
