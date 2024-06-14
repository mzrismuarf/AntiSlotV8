@if (!empty($scannedFiles))
    <h4>Files containing specified keywords:</h4>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">Path</th>
                <th scope="col">Word</th>
                <th scope="col">Date</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($scannedFiles as $index => $file)
                <tr data-file="{{ $file['path'] }}">
                    <td>{{ $file['path'] }}</td>
                    <td>{{ $file['word'] }}</td>
                    <td>{{ $file['modification_time'] }}</td>
                    <td>
                        <button type="button" class="btn btn-primary edit-btn" data-toggle="modal"
                            data-target="#editModal{{ $index }}" data-file="{{ $file['path'] }}">Edit</button>
                        <button type="button" class="btn btn-danger delete-btn" data-toggle="modal"
                            data-target="#deleteModal{{ $index }}"
                            data-file="{{ $file['path'] }}">Delete</button>
                    </td>
                </tr>
                <!-- Edit Modal -->
                <div class="modal fade" id="editModal{{ $index }}" tabindex="-1" role="dialog"
                    aria-labelledby="editModalLabel{{ $index }}" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editModalLabel{{ $index }}">Edit File:
                                    {{ $file['path'] }}</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <!-- Ensure the ID here is unique -->
                                <textarea id="fileContent{{ $index }}" class="form-control" rows="10"></textarea>
                                <input type="hidden" id="originalContent{{ $index }}" value="">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-success save-changes-btn">Save Changes</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Delete Modal -->
                <div class="modal fade" id="deleteModal{{ $index }}" tabindex="-1" role="dialog"
                    aria-labelledby="deleteModalLabel{{ $index }}" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="deleteModalLabel{{ $index }}">Delete File:
                                    {{ $file['path'] }}</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                Are you sure you want to delete this file?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal"
                                    id="cancelDelete{{ $index }}">Cancel</button>
                                <!-- We should use a class for confirm delete -->
                                <button type="button" class="btn btn-danger confirm-delete-btn"
                                    data-file="{{ $file['path'] }}">Delete</button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </tbody>
    </table>
@else
    @if (!empty($error))
        <div class="alert alert-secondary"><i class="bi bi-exclamation-circle"></i> {{ $error }}</div>
    @elseif (isset($directory) && !is_dir($directory))
        <div class="alert alert-secondary"><i class="bi bi-exclamation-circle"></i>{{ $safe }}</div>
    @else
    @endif
    @if (!empty($safe))
        <div class="alert alert-success"><i class="bi bi-check-circle"></i> {{ $safe }}</div>
    @else
    @endif
@endif


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        // Function to handle file deletion
        $('.delete-btn').on('click', function() {
            var filePath = $(this).data('file');
            var modalIndex = $(this).data('target').replace('#deleteModal', '');
            $('#deleteModal' + modalIndex).modal('show');

            // Confirm delete
            $('.confirm-delete-btn').off('click').on('click', function() {
                $.ajax({
                    url: "{{ route('deleteFile') }}",
                    method: 'POST',
                    data: {
                        filePath: filePath,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        // Optionally show success message
                        alert('File deleted successfully!');
                        $('#deleteModal' + modalIndex).modal('hide');
                        // Remove the row from the table
                        $('tr[data-file="' + filePath + '"]').remove();
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                        // Show error message
                        alert('Error deleting file.');
                    }
                });
            });

            // Cancel delete
            $('#cancelDelete' + modalIndex).on('click', function() {
                $('#deleteModal' + modalIndex).modal('hide');
            });

            // Close modal without deleting
            $(document).on('click', '.close', function() {
                $('#deleteModal' + modalIndex).modal('hide'); // Hide modal
            });

        });



        // Edit modal
        $('.edit-btn').on('click', function() {
            var filePath = $(this).data('file');
            var modalIndex = $(this).data('target').replace('#editModal', '');
            $.ajax({
                url: "{{ route('getFileContent') }}",
                method: 'GET',
                data: {
                    filePath: filePath
                },
                success: function(response) {
                    $('#fileContent' + modalIndex).val(response.content);
                    $('#originalContent' + modalIndex).val(response
                        .content); // Save original content
                    $('#editModal' + modalIndex).modal(
                        'show'); // Show modal after content is loaded
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                    // Show error message
                    $('#fileContent' + modalIndex).val("Error loading file content.");
                    $('#originalContent' + modalIndex).val(""); // Clear original content
                    $('#editModal' + modalIndex).modal('show'); // Still show modal on error
                }
            });
        });

        // Switch to edit mode
        $(document).on('click', '.edit-mode-btn', function() {
            var modalIndex = $(this).closest('.modal').attr('id').replace('editModal', '');
            // $('#fileContent' + modalIndex).prop('readonly', false).focus();
            $('#fileContent' + modalIndex).focus();
        });

        // Close modal without saving changes
        $(document).on('click', '.close', function() {
            var modalIndex = $(this).closest('.modal').attr('id').replace('editModal', '');
            var originalContent = $('#originalContent' + modalIndex).val();
            $('#fileContent' + modalIndex).val(originalContent); // Restore original content
            $('#editModal' + modalIndex).modal('hide'); // Hide modal
        });

        // Save changes
        $(document).on('click', '.save-changes-btn', function() {
            var modalIndex = $(this).closest('.modal').attr('id').replace('editModal', '');
            var newContent = $('#fileContent' + modalIndex).val();
            var filePath = $('.edit-btn[data-target="#editModal' + modalIndex + '"]').data('file');
            $.ajax({
                url: "{{ route('saveFileContent') }}",
                method: 'POST',
                data: {
                    filePath: filePath,
                    newContent: newContent,
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    // Optionally show success message
                    alert('Changes saved successfully!');
                    $('#editModal' + modalIndex).modal('hide');
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                    // Show error message
                    alert('Error saving changes.');
                }
            });
        });
    });
</script>
