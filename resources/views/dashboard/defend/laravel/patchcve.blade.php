{{-- Wordpress Disable XMLRPC --}}

@extends('kerangka.laravel');
@section('title', 'Patch CVE Laravel');
@section('content')
    <div class="container mt-5">
        <h2>Patch CVE Laravel</h2>
        <div class="container mt-5">
            <h2>Choose folder for .htaccess file</h2>
            <div class="row mt-4">
                <div class="col-md-6">
                    <form action="{{ route('laravel.patchcve.search') }}" method="post">
                        @csrf
                        <div class="mb-3">
                            <label for="folderName" class="form-label">Folder Name</label>
                            <input type="text" placeholder="/var/www/laravel" class="form-control" id="folderName"
                                name="folderName" required>
                        </div>
                        <button type="submit" class="btn btn-primary" name="search">Search</button>
                    </form>
                    <div class="row">
                        <div class="col">
                            <h4>.htaccess for patch cve</h4>
                            <textarea id="textarea1" class="form-control" rows="10" name="contentFromTextarea1">{{ file_get_contents(Storage::path('public/patch-cve.txt')) }}</textarea>
                        </div>
                        <div class="col">
                            @if (isset($htaccessFiles))
                                @if (count($htaccessFiles) > 0)
                                    <h4>.htaccess File Found</h4>
                                    @foreach ($htaccessFiles as $file)
                                        <form action="{{ route('laravel.patchcve.add') }}" method="post">
                                            @csrf
                                            <textarea id="textarea2" class="form-control" rows="10" name="existingContent">{{ file_get_contents($folderName . '/' . $file) }}</textarea><br>
                                            <input type="hidden" name="filePath" value="{{ $folderName . '/' . $file }}">
                                            <input type="hidden" name="contentFromTextarea1"
                                                value="{{ htmlentities(file_get_contents(Storage::path('public/patch-cve.txt'))) }}">
                                            <button type="submit" class="btn btn-success" name="add">Add</button>
                                        </form>
                                    @endforeach
                                @else
                                    <h4>No .htaccess File Found in {{ $folderName }}</h4>
                                    <form action="{{ route('laravel.patchcve.addHtaccess') }}" method="post">
                                        @csrf
                                        <input type="hidden" name="folderName" value="{{ $folderName }}">
                                        <input type="hidden" name="contentFromTextarea1"
                                            value="{{ htmlentities(file_get_contents(Storage::path('public/patch-cve.txt'))) }}">
                                        <button type="submit" class="btn btn-primary" name="addHtaccess">Add
                                            .htaccess</button>
                                    </form>
                                @endif
                            @endif
                            @if (isset($noHtaccess))
                                <div class="alert alert-warning" role="alert">
                                    No .htaccess file found in {{ $folderName }}
                                </div>
                            @endif
                            @if (isset($error))
                                <div class="alert alert-danger" role="alert">
                                    {{ $error }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    @if (isset($addSuccess))
                        <div class="alert alert-success" role="alert">{{ $addSuccess }}</div>
                        <textarea class="form-control mt-3" rows="10">{{ $fileContent }}</textarea>
                    @elseif(isset($confirmation))
                        <div id="confirmation" class="alert alert-warning" role="alert">Are you sure you want to add
                            .htaccess?
                            <form id="confirmForm" action="{{ route('laravel.patchcve.confirmAdd') }}" method="post">
                                @csrf
                                <input type="hidden" name="folderName" value="{{ $folderName }}">
                                <input type="hidden" name="contentFromTextarea1" value="{{ $contentFromTextarea1 }}">
                                <button type="submit" class="btn btn-primary" name="confirmAdd">Yes</button>
                                &nbsp;
                                <button type="button" class="btn btn-secondary" onclick="hideConfirmation()">No</button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        function hideConfirmation() {
            document.getElementById("confirmation").style.display = "none";
        }
    </script>
@endsection
