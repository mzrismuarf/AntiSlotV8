{{-- Wordpress Disable XMLRPC --}}

@extends('kerangka.wordpress');
@section('title', 'Disable XMLRPC');
@section('content')
    <div class="container mt-5">
        <h2>Disable XMLRPC</h2>
        <div class="row mt-4">
            <div class="col-md-6">
                <form action="{{ route('search') }}" method="post">
                    @csrf
                    <div class="mb-3">
                        <label for="folderName" class="form-label">Folder Name</label>
                        <input type="text" class="form-control" id="folderName" name="folderName" required>
                    </div>
                    <button type="submit" class="btn btn-primary" name="search">Search</button>
                </form>
                <div class="row">
                    <div class="col">
                        <h4>.htaccess Disable XMLRPC</h4>
                        <textarea id="textarea1" class="form-control" rows="10" name="contentFromTextarea1">{{ file_get_contents(Storage::path('public/disable_xmlrpc.txt')) }}</textarea>
                    </div>
                    <div class="col">
                        @if (isset($htaccessFiles))
                            @if (count($htaccessFiles) > 0)
                                <h4>.htaccess File Found</h4>
                                @foreach ($htaccessFiles as $file)
                                    <form action="{{ route('add') }}" method="post">
                                        @csrf
                                        <textarea id="textarea2" class="form-control" rows="10" name="existingContent">{{ file_get_contents($folderName . '/' . $file) }}</textarea><br>
                                        <input type="hidden" name="filePath" value="{{ $folderName . '/' . $file }}">
                                        <input type="hidden" name="contentFromTextarea1"
                                            value="{{ htmlentities(file_get_contents(Storage::path('public/disable_xmlrpc.txt'))) }}">
                                        <button type="submit" class="btn btn-success" name="add">Add</button>
                                    </form>
                                @endforeach
                            @else
                                <h4>No .htaccess File Found in {{ $folderName }}</h4>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                @if (isset($addedContent))
                    <div class="alert alert-success" role="alert">Content added successfully!</div>
                    <textarea class="form-control mt-3" rows="10">{{ $addedContent }}</textarea>
                @endif
            </div>
        </div>
    </div>
@endsection
