@extends('layouts.app')

@section('title', 'Add Speaker')

@section('content')
    <div class="page-header">
        <h1>Add New Speaker</h1>
        <p>Create a speaker profile for the conference website.</p>
    </div>

    <div class="card">
        <form method="POST" action="{{ url('/speakers') }}" enctype="multipart/form-data">
            @csrf

            <label>Speaker Name</label>
            <input type="text" name="name" required>

            <label>Email</label>
            <input type="email" name="email">

            <label>Topic</label>
            <input type="text" name="topic" required>

            <label>Category</label>
            <select name="category_id">
                <option value="">Select category</option>

                @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>

            <label>Speaker Photo</label>
            <input type="file" name="photo" accept="image/*">

            <label>Bio</label>
            <textarea name="bio" rows="5"></textarea>

            <button class="btn" type="submit">Save Speaker</button>
            <a class="btn btn-secondary" href="{{ url('/speakers') }}">Cancel</a>
        </form>
    </div>
@endsection