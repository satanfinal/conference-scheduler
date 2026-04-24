@extends('layouts.app')

@section('title', 'Categories')

@section('content')
    <main class="page">
        <div class="page-header">
            <h1>Conference Categories</h1>
            <p>Explore built in conference tracks and find speakers or sessions by topic.</p>
        </div>

        @php
            $descriptions = [
                'Technology' => 'Sessions about software, AI, web development and digital innovation.',
                'Business' => 'Sessions about entrepreneurship, leadership, startups and business strategy.',
                'Education' => 'Sessions about learning, teaching, training and academic development.',
                'Design' => 'Sessions about UI, UX, branding, creativity and product design.',
                'Health' => 'Sessions about health technology, wellness and healthcare innovation.',
                'Marketing' => 'Sessions about digital marketing, content strategy and customer engagement.',
            ];
        @endphp

        <div class="card">
            @if($categories->count() > 0)
                <table>
                    <thead>
                        <tr>
                            <th>Category Name</th>
                            <th>Description</th>
                            <th>Details</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($categories as $category)
                            <tr>
                                <td>{{ $category->name }}</td>
                                <td>{{ $descriptions[$category->name] ?? 'Conference sessions and speakers related to this topic.' }}</td>
                                <td>
                                    <a class="btn" href="{{ url('/category/' . $category->id) }}">View Category</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p class="empty">No categories found.</p>
            @endif
        </div>
    </main>
@endsection