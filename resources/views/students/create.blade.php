@extends('dashboard')
@section('content')
<h1>Add Student</h1>
    <form action="{{ route('students.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label class="form-label">Name:</label>
            <input type="text" class="form-control" name="name" value="{{ old('name') }}" required>
            @error('name')
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
            <label class="form-label">Image:</label>
            <input type="file" class="form-control" name="image">
            @error('image')
                <div>{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label class="form-label">Class:</label>
            <select name="class_id" class="form-control" required>
                <option value="">Select Class</option>
                @foreach($classes as $id => $class)
                    <option value="{{ $id }}">{{ $class }}</option>
                @endforeach
            </select>
            @error('class')
                <div>{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label class="form-label">Roll Number:</label>
            <input type="text" class="form-control" name="roll_number" value="{{ old('roll_number') }}" required>
            @error('roll_number')
                <div>{{ $message }}</div>
            @enderror
        </div>
        <button class="btn btn-primary" type="submit">Add Student</button>
    </form>
@endsection