@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="my-4">Contacts List</h2>

    <!-- Add Contact Button -->
    <div class="mb-3">
        <a href="{{ route('contacts.create') }}" class="btn btn-success">Add Contact</a>
    </div>

    <!-- XML Import Form -->
    <div class="mb-4">
        <form action="{{ route('contacts.importXML') }}" method="POST" enctype="multipart/form-data" id="xmlForm">
            @csrf
            <div class="input-group">
                <input type="file" name="xml_file" id="xml_file" class="form-control" required>
                <button type="submit" class="btn btn-primary">Import XML</button>
            </div>
        </form>
    </div>

    <!-- Error Handling for Validation -->
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <!-- Contacts Table -->
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="table-light">
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Company</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($contacts as $contact)
                <tr>
                    <td>{{ $contact->first_name }} {{ $contact->last_name }}</td>
                    <td>{{ $contact->email }}</td>
                    <td>{{ $contact->phone_number }}</td>
                    <td>{{ $contact->company_name }}</td>
                    <td class="d-flex">
                        <a href="{{ route('contacts.show', $contact->id) }}" class="btn btn-info btn-sm me-2">View</a>
                        <a href="{{ route('contacts.edit', $contact->id) }}" class="btn btn-warning btn-sm me-2">Edit</a>
                        <form action="{{ route('contacts.destroy', $contact->id) }}" method="POST" style="display:inline;" onsubmit="return confirmDelete()">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script>
    // Confirmation prompt before deleting contact
    function confirmDelete() {
        return window.confirm('Are you sure you want to delete this contact?');
    }

    // File size validation before form submission
    document.getElementById('xmlForm').addEventListener('submit', function(event) {
        var fileInput = document.getElementById('xml_file');
        var file = fileInput.files[0];

        if (file.size > 10 * 1024 * 1024) {
            event.preventDefault();
            alert('File size exceeds the maximum limit of 10MB.');
        }
    });
</script>
@endsection
