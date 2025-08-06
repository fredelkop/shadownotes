@extends('layouts.app', [
    'namePage' => 'Dashboard',
    'class' => 'login-page sidebar-mini ',
    'activePage' => 'home',
    'backgroundImage' => asset('now') . "/img/bg14.jpg",
])

{{-- @if(session()->has('success'))
    <script>
        nowuiDashboard.showSidebarMessage({{ session('success') }});
    </script>
@endif --}}

@section('content')
<div class="panel-header panel-header-sm"></div>
<div class="content">
    <div class="row">
        @if(session('success'))
        <div class="col-md-8 mx-auto">
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        </div>
        @endif
        <div class="col-md-8 mx-auto">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title">My Notes</h4>
                    <a href="{{ route('notes.create') }}" class="btn btn-primary btn-round">
                        <i class="now-ui-icons ui-1_simple-add"></i> New Note
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="datatable" class="table table-striped table-bordered" cellspacing="0" width="100%">
                            <thead class="text-primary">
                                <th>Title</th>
                                <th>Last Updated</th>
                                <th class="text-right">Actions</th>
                            </thead>
                            <tbody>
                                @foreach($notes as $note)
                                <tr>
                                    <td>{{ $note->title }}</td>
                                    <td>{{ $note->updated_at->diffForHumans() }}</td>
                                    <td class="text-right">
                                        <a href="{{ route('notes.edit', $note->id) }}" class="btn btn-info btn-sm btn-round btn-icon">
                                            <i class="now-ui-icons ui-2_settings-90"></i>
                                        </a>
                                        <form action="{{ route('notes.destroy', $note->id) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm btn-round btn-icon"
                                                    onclick="return confirm('Delete this note permanently?')">
                                                <i class="now-ui-icons ui-1_simple-remove"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer">
                        <div class="stats">
                            <i class="now-ui-icons arrows-1_refresh-69"></i> Just Updated
                        </div>
                    </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
<script>
$(document).ready(function() {
    // CSRF token setup
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Create note - working correctly
    $('#createNoteForm').submit(function(e) {
        e.preventDefault();
        $.post("{{ route('notes.store') }}", $(this).serialize())
            .done(function() {
                $('#createNoteModal').modal('hide');
                location.reload();
            })
            .fail(function(xhr) {
                console.log(xhr.responseJSON);
                alert('Error: ' + (xhr.responseJSON.message || 'Unknown error'));
            });
    });
});
</script>
@endpush
