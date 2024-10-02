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
            <a href="{{ route('wordlist.create') }}" class="btn btn-primary mb-3">Add Wordlist</a>
            <a href="{{ route('wordlist.downloadTemplate') }}" class="btn btn-success mb-3">Download Template</a>
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
                            <h5 class="card-title">Data Wordlists</h5>
                        </div>
                        <div class="card-body">
                            <!-- Table with no outer spacing -->
                            <table class="table table-striped" id="table1">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Best Wordlist Slot</th>
                                        <th>Slot</th>
                                        <th>Backdoor</th>
                                        <th>Disabel File Modif</th>
                                        <th>Disable XMLRPC</th>
                                        <th>Patch CVE</th>
                                        <th>Validation File Upload</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($wordlistSlot as $key => $data)
                                        <tr>
                                            <td>{{ $wordlistSlot->firstItem() + $key }}</td>
                                            <td>{{ $data->best_wordlist_slot }}</td>
                                            <td>{{ $data->slot }}</td>
                                            <td>{{ $data->backdoor }}</td>
                                            <td>{{ $data->disable_file_modif }}</td>
                                            <td>{{ $data->disable_xmlrpc }}</td>
                                            <td>{{ $data->patch_cve }}</td>
                                            <td>{{ $data->validation_upload }}</td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <button type="submit" class="btn btn-primary mx-1">
                                                        <a href="{{ route('wordlist.edit', $data->id) }}">
                                                            <i class="bi bi-pencil-square" style="color: white"></i>
                                                        </a>
                                                    </button>
                                                    <form action="{{ route('wordlist.destroy', $data->id) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger mx-1 mt-3">
                                                            <i class="bi bi-trash3"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="dataTable-bottom">
                                <div class="float-start">
                                    Showing
                                    {{ $wordlistSlot->firstItem() }}
                                    to
                                    {{ $wordlistSlot->lastItem() }}
                                    of
                                    {{ $wordlistSlot->lastPage() }}
                                    entries
                                </div>
                                <div class="float-end">
                                    {{ $wordlistSlot->onEachSide(2)->links() }}
                                </div>
                            </div>
                            <div>
                            </div>
                        </div>
                </section>
                <!-- Basic Tables end -->
            </div>
        </div>
    </div>
    <!-- @include('dashboard.scan.result') -->
@endsection
