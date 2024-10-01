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
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
        @endif
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Edit Wordlists</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('wordlist.update', $wordlist->id) }}" method="POST">
                    @csrf
                    @method('PUT')
            
                    <!-- Field untuk mengedit data, user bisa mengosongkan field -->
                    <div class="form-group">
                        <label for="slot">Best Wordlist Slot</label>
                        <input type="text" class="form-control" name="best_wordlist_slot" value="{{ old('best_wordlist_slot', $wordlist->best_wordlist_slot) }}">
                    </div>
                    <div class="form-group">
                        <label for="slot">Slot</label>
                        <input type="text" class="form-control" name="slot" value="{{ old('slot', $wordlist->slot) }}">
                    </div>
                    <div class="form-group">
                        <label for="backdoor">Backdoor</label>
                        <input type="text" class="form-control" name="backdoor" value="{{ old('backdoor', $wordlist->backdoor) }}">
                    </div>
                    <div class="form-group">
                        <label for="disable_file_modif">Disable File Modif</label>
                        <input type="text" class="form-control" name="disable_file_modif" value="{{ old('disable_file_modif', $wordlist->disable_file_modif) }}">
                    </div>
                    <div class="form-group">
                        <label for="disable_xmlrpc">Disable Xmlrpc</label>
                        <input type="text" class="form-control" name="disable_xmlrpc" value="{{ old('disable_xmlrpc', $wordlist->disable_xmlrpc) }}">
                    </div>
                    <div class="form-group">
                        <label for="patch_cve">Patch CVE</label>
                        <input type="text" class="form-control" name="patch_cve" value="{{ old('patch_cve', $wordlist->patch_cve) }}">
                    </div>
                    <div class="form-group">
                        <label for="validation_upload">Validation Upload</label>
                        <input type="text" class="form-control" name="validation_upload" value="{{ old('validation_upload', $wordlist->validation_upload) }}">
                    </div>
                    <!-- Tambahkan field lainnya sesuai kebutuhan -->
                    
                    <button type="submit" class="btn btn-primary">Update</button>
                    <!-- Tombol Cancel untuk kembali ke halaman sebelumnya -->
                    <a href="javascript:history.back()" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
    </section>
    <!-- Basic Tables end -->
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