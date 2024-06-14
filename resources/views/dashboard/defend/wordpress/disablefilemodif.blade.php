{{-- Wordpress Disable File Modifications --}}

@extends('kerangka.wordpress')
@section('title', 'Disable File Modifications')
@section('content')
    <div class="container mt-5">
        <h2> Wordpress Disable File Modifications</h2>
        <div class="row mt-4">
            <div class="col-md-6">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (isset($directoryNotFound) && $directoryNotFound)
                    <div class="alert alert-danger" role="alert">Directory Not Found</div>
                @endif

                <form action="{{ route('defend.wp.disablefile.search') }}" method="post">
                    @csrf
                    <div class="mb-3">
                        <label for="folderName" class="form-label">Folder Name</label>
                        <input type="text" class="form-control" id="folderName" name="folderName" required>
                    </div>
                    <button type="submit" class="btn btn-primary" name="search">Search</button>
                </form>
                <div class="row">
                    <div class="col">
                        <h4>wp-config.php for Disable File Modifications</h4>
                        <textarea id="textarea1" class="form-control" rows="10" name="contentFromTextarea1">{{ file_get_contents(Storage::path('public/disable_file_modif.txt')) }}</textarea>
                    </div>
                    <div class="col">
                        @if (isset($wpconfigFiles) && count($wpconfigFiles) > 0)
                            <h4>wp-config.php File Found</h4>
                            @foreach ($wpconfigFiles as $file)
                                @php
                                    $wpConfigFile = $folderName . '/' . $file;
                                @endphp
                                <form action="{{ route('defend.wp.disablefile.add') }}" method="post">
                                    @csrf
                                    <textarea id="textarea2" class="form-control" rows="10" name="existingContent">{{ file_get_contents($wpConfigFile) }}</textarea><br>
                                    <input type="hidden" name="filePath" value="{{ $wpConfigFile }}">
                                    <input type="hidden" name="contentFromTextarea1"
                                        value="{{ htmlentities(file_get_contents(Storage::path('public/disable_file_modif.txt'))) }}">
                                    <button type="submit" class="btn btn-success" name="add">Add</button>
                                </form>
                            @endforeach
                        @elseif (isset($folderName) && empty($wpconfigFiles))
                            <h4>No wp-config.php File Found in {{ $folderName }}</h4>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                @if (isset($newContentAdded))
                    <div class="alert alert-success" role="alert">Content added successfully!</div>
                    <textarea class="form-control mt-3" rows="10">{{ $newContentAdded }}</textarea>
                @endif
            </div>
        </div>
    </div>
@endsection
