<!-- resources/views/teachers/create.blade.php -->

@extends('dashboard')

@section('content')
    <h1>Add Teacher</h1>
    <form action="{{ route('teachers.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label class="form-label">Name:</label>
            <input class="form-control" type="text" name="name" value="{{ old('name') }}" required>
            @error('name')
                <div>{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label class="form-label">Image:</label>
            <input class="form-control" type="file" name="image">
            @error('image')
                <div>{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label class="form-label">Age:</label>
            <input type="text" class="form-control" name="age" value="{{ old('age') }}" required>
            @error('age')
                <div>{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label class="form-label">Sex:</label>
            <select class="form-control" name="sex" required>
                <option value="male">Male</option>
                <option value="female">Female</option>
            </select>
            @error('sex')
                <div>{{ $message }}</div>
            @enderror
        </div>
        <button class="btn btn-primary" type="submit">Add Teacher</button>
    </form>
@endsection
