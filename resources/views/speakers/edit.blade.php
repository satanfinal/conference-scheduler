@extends('layouts.app')

@section('title', 'Edit Speaker')

@section('content')
    <main class="page">
        <div class="page-header">
            <h1>Edit Speaker</h1>
            <p>Update speaker profile, topic, category and photo.</p>
        </div>

        <div class="card">
            @if($errors->any())
                <div class="error-box">
                    @foreach($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ url('/speakers/' . $speaker->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <label for="name">Speaker Name</label>
                <input
                    type="text"
                    id="name"
                    name="name"
                    value="{{ old('name', $speaker->name) }}"
                    required
                >

                <label for="email">Email</label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    value="{{ old('email', $speaker->email) }}"
                >

                <label for="topic">Topic</label>
                <input
                    type="text"
                    id="topic"
                    name="topic"
                    value="{{ old('topic', $speaker->topic) }}"
                    required
                >

                <label for="category_id">Category</label>
                <select id="category_id" name="category_id">
                    <option value="">No category selected</option>

                    @foreach($categories as $category)
                        <option
                            value="{{ $category->id }}"
                            {{ old('category_id', $speaker->category_id) == $category->id ? 'selected' : '' }}
                        >
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>

                <label for="photo">Speaker Photo</label>

                @if($speaker->photo)
                    <div style="margin-bottom: 12px;">
                        <img
                            src="{{ asset('storage/' . $speaker->photo) }}"
                            alt="{{ $speaker->name }}"
                            style="width: 120px; height: 120px; object-fit: cover; border-radius: 12px;"
                        >
                    </div>
                @endif

                <input type="file" id="photo" name="photo" accept="image/*">

                <label for="bio">Bio</label>
                <textarea id="bio" name="bio" rows="5">{{ old('bio', $speaker->bio) }}</textarea>

                <button class="btn" type="submit">Update Speaker</button>
                <a class="btn btn-secondary" href="{{ url('/speakers/' . $speaker->id) }}">Cancel</a>
            </form>
        </div>
    </main>
@endsection