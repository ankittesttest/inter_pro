@extends('dashboard')
@section('content')
    <h1>Add Subject</h1>
    <form action="{{ route('subjects.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label class="form-label">Name:</label>
            <input class="form-control" type="text" name="name" value="{{ old('name') }}" required>
            @error('name')
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
            <label class="form-label">Languages:</label>
            <select class="form-control" name="languages[]" multiple>
                <option value="">Select Language</option>
                @foreach($language as $id => $language_name)
                    <option value="{{ $id }}">{{ $language_name }}</option>
                @endforeach
            </select>
            @error('languages')
                <div>{{ $message }}</div>
            @enderror
        </div>
        <button class="btn btn-primary" type="submit">Add Subject</button>
    </form>
@endsection