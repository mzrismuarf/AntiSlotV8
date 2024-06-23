    <!-- Basic Tables start -->
    <section class="section">
        @if (session('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
        @endif
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Data result scan</h5>
            </div>
            <div class="card-body">
                <!-- Table with no outer spacing -->
                <table class="table table-striped" id="table1">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Directory Scan</th>
                            <th>Direcotry Safe</th>
                            <th>Direcotry Infected</th>
                            <th>Backlink Slot</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($ResultData as $key => $data)
                        <tr>
                            <td>{{ $ResultData->firstItem() + $key }}</td>
                            <td>{{ $data->directory_scan }}</td>
                            <td>{{ $data->directory_safe }}</td>
                            <td>{{ $data->directory_infected }}</td>
                            <td>{{ $data->backlink_slot }}</td>
                            <td>
                                <div class="d-flex">
                                    <form action="{{ route('dashboard.destroy', $data->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger mx-1" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
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
                        {{ $ResultData->firstItem() }}
                        to
                        {{ $ResultData->lastItem() }}
                        of
                        {{ $ResultData->lastPage() }}
                        entries
                    </div>
                    <div class="float-end">
                        {{ $ResultData->onEachSide(2)->links() }}
                    </div>
                </div>
                <div>
                </div>
            </div>
    </section>
    <!-- Basic Tables end -->