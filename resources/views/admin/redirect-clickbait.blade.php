@extends('admin.layouts.master')

@section('title')
    Redirect Clickbait
@endsection

@section('content')
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Redirect Clickbait</h1>
    <p class="mb-4"></p>

    <!-- Button to Open Create Modal -->
    <button class="btn btn-primary mb-4" data-toggle="modal" data-target="#createModal">
        Add New Redirect Clickbait
    </button>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Redirect Clickbait</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Short URL</th>
                            <th>Code</th>
                            <th>Title</th>
                            <th>URL</th>
                            <th>Banner</th>
                            <th>Hits</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($redirectClickbait as $item)
                            <tr>
                                <td>
                                    <div class="input-group">
                                        <input type="text" class="form-control form-control-sm"
                                            id="shorturl{{ $item->id }}" value="{{ url('/r/' . $item->code) }}"
                                            readonly>
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-secondary btn-sm copy-btn" data-toggle="tooltip"
                                                title="Copy URL" onclick="copyToClipboard('shorturl{{ $item->id }}')">
                                                <i class="fas fa-copy"></i>
                                            </button>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $item->code }}</td>
                                <td>{{ $item->title }}</td>
                                <td>{{ Str::limit($item->url, 40) }}</td>
                                <td>
                                    @if ($item->banner_image)
                                        <img src="{{ asset('storage/' . $item->banner_image) }}" alt="Banner"
                                            width="50" height="50" class="img-thumbnail">
                                    @else
                                        No Banner
                                    @endif
                                </td>
                                <td>{{ $item->hits }}</td>
                                <td>
                                    <span class="badge badge-{{ $item->status === 'active' ? 'success' : 'danger' }}">
                                        {{ $item->status }}
                                    </span>
                                </td>
                                <td>
                                    <button class="btn btn-warning btn-sm" data-toggle="modal"
                                        data-target="#editModal-{{ $item->id }}">
                                        <i class="fas fa-edit"></i> Edit
                                    </button>
                                    <button class="btn btn-danger btn-sm" data-toggle="modal"
                                        data-target="#deleteModal-{{ $item->id }}">
                                        <i class="fas fa-trash"></i> Delete
                                    </button>
                                </td>
                            </tr>

                            <!-- Edit Modal -->
                            <div class="modal fade" id="editModal-{{ $item->id }}" tabindex="-1">
                                <div class="modal-dialog">
                                    <form action="{{ route('admin.redirect-clickbait.update', $item->id) }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Edit Redirect Clickbait</h5>
                                                <button type="button" class="close" data-dismiss="modal">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label>Code</label>
                                                    <input type="text" name="code" class="form-control"
                                                        value="{{ $item->code }}" required>
                                                </div>
                                                <div class="form-group">
                                                    <label>Title</label>
                                                    <input type="text" name="title" class="form-control"
                                                        value="{{ $item->title }}" required>
                                                </div>
                                                <div class="form-group">
                                                    <label>Original URL</label>
                                                    <input type="url" name="url" class="form-control"
                                                        value="{{ $item->url }}" required>
                                                </div>
                                                <div class="form-group">
                                                    <label>Status</label>
                                                    <select name="status" class="form-control">
                                                        <option value="active"
                                                            {{ $item->status === 'active' ? 'selected' : '' }}>Active
                                                        </option>
                                                        <option value="inactive"
                                                            {{ $item->status === 'inactive' ? 'selected' : '' }}>Inactive
                                                        </option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label>Banner Image</label>
                                                    @if ($item->banner_image)
                                                        <div class="mb-2">
                                                            <img src="{{ asset($item->banner_image) }}"
                                                                alt="Current Banner" class="img-thumbnail"
                                                                style="max-height: 100px;">
                                                        </div>
                                                    @endif
                                                    <input type="file" name="banner_image" class="form-control"
                                                        accept="image/*">
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Save Changes</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <!-- Delete Modal -->
                            <div class="modal fade" id="deleteModal-{{ $item->id }}" tabindex="-1">
                                <div class="modal-dialog">
                                    <form action="{{ route('admin.redirect-clickbait.destroy', $item->id) }}"
                                        method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Delete Redirect Clickbait</h5>
                                                <button type="button" class="close" data-dismiss="modal">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                Are you sure you want to delete this redirect Clickbait?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">Cancel</button>
                                                <button type="submit" class="btn btn-danger">Delete</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Create Modal -->
    <div class="modal fade" id="createModal" tabindex="-1">
        <div class="modal-dialog">
            <form action="{{ route('admin.redirect-clickbait.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add New Redirect Clickbait</h5>
                        <button type="button" class="close" data-dismiss="modal">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Code</label>
                            <input type="text" name="code" class="form-control" required>
                            <small class="form-text text-muted">Enter a unique code for this redirect</small>
                        </div>
                        <div class="form-group">
                            <label>Title</label>
                            <input type="text" name="title" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Original URL</label>
                            <input type="url" name="url" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Status</label>
                            <select name="status" class="form-control">
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Banner Image</label>
                            <input type="file" name="banner_image" class="form-control" accept="image/*">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function copyToClipboard(elementId) {
            const element = document.getElementById(elementId);
            element.select();
            document.execCommand('copy');

            // Show tooltip
            const tooltip = document.createElement('div');
            tooltip.className = 'tooltip show';
            tooltip.style.position = 'absolute';
            tooltip.innerHTML = 'Copied!';
            document.body.appendChild(tooltip);

            // Position the tooltip
            const buttonRect = element.nextElementSibling.getBoundingClientRect();
            tooltip.style.top = buttonRect.top - 30 + 'px';
            tooltip.style.left = buttonRect.left + 'px';

            // Remove tooltip after 2 seconds
            setTimeout(() => {
                tooltip.remove();
            }, 2000);
        }

        // Initialize tooltips
        $(function() {
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>

    <style>
        .tooltip.show {
            opacity: 1;
            background: #333;
            color: white;
            padding: 5px 10px;
            border-radius: 3px;
            font-size: 12px;
        }
    </style>
@endpush
