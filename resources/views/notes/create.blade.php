@extends('layouts.app', [
    'namePage' => 'Create Note',
    'class' => 'sidebar-mini',
    'activePage' => 'home',
    'backgroundImage' => asset('now') . "/img/bg14.jpg",
])

@if($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

@section('content')
<div class="panel-header panel-header-sm"></div>
<div class="content">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card">
                <div class="card-header">
                    <a href="{{ route('home') }}" class="btn btn-default float-right">Back</a>
                    <h4 class="card-title">Create New Note</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('notes.store') }}">
                        @csrf
                        <div class="form-group">
                            <label>Title</label>
                            <input type="text" name="title" class="form-control" required maxlength="255">
                            <small id="title-counter" class="form-text text-muted">255 characters remaining</small>
                        </div>
                        <div class="form-group">
                            <label>Content</label>
                            <textarea name="content" class="form-control" rows="10" required></textarea>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Save Note</button>
                            <a href="{{ route('home') }}" class="btn btn-default">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
<script>
$(document).ready(function() {
    // Character counter for title
    $('input[name="title"]').on('input', function() {
        const remaining = 255 - $(this).val().length;
        $('#title-counter').text(remaining + ' characters remaining');
    });
});
</script>
@endpush
