@extends('layouts.app')

@section('content')
<h2>Contact Details</h2>

<table class="table table-bordered">
    <tr>
        <th>First Name:</th>
        <td>{{ $contact->first_name }}</td>
    </tr>
    <tr>
        <th>Last Name:</th>
        <td>{{ $contact->last_name }}</td>
    </tr>
    <tr>
        <th>Email:</th>
        <td>{{ $contact->email }}</td>
    </tr>
    <tr>
        <th>Phone Number:</th>
        <td>{{ $contact->phone_number }}</td>
    </tr>
    <tr>
        <th>Company Name:</th>
        <td>{{ $contact->company_name }}</td>
    </tr>
</table>

<a href="{{ route('contacts.edit', $contact->id) }}" class="btn btn-warning">Edit</a>
<a href="{{ route('contacts.index') }}" class="btn btn-secondary">Back to List</a>

<form action="{{ route('contacts.destroy', $contact->id) }}" method="POST" style="display:inline;">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-danger">Delete</button>
</form>
@endsection
