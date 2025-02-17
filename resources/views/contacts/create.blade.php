@extends('layouts.app')

@section('content')
<h2>Add New Contact</h2>

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('contacts.store') }}" method="POST">
    @csrf

    <div class="mb-3">
        <label for="first_name" class="form-label">First Name : </label>
        <input type="text" name="first_name" class="form-control" required>
    </div>

    <div class="mb-3">
        <label for="last_name" class="form-label">Last Name : </label>
        <input type="text" name="last_name" class="form-control" required>
    </div>

    <div class="mb-3">
        <label for="email" class="form-label">Email : </label>
        <input type="email" name="email" class="form-control" required>
    </div>

    <div class="mb-3">
        <label for="phone_number" class="form-label">Phone Number : </label>
        <input type="text" name="phone_number" class="form-control" required>
    </div>

    <div class="mb-3">
        <label for="company_name" class="form-label">Company Name : </label>
        <input type="text" name="company_name" class="form-control">
    </div>

    <button type="submit" class="btn btn-primary">Save Contact</button>
    <a href="{{ route('contacts.index') }}" class="btn btn-secondary">Back to List</a>
</form>
@endsection
