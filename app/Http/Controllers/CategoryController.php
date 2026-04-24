<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Speaker;
use App\Models\Event;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();

        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        if (!auth()->user()->is_admin) {
            abort(403, 'Only admins can create categories.');
        }

        return view('categories.create');
    }

    public function store(Request $request)
    {
        if (!auth()->user()->is_admin) {
            abort(403, 'Only admins can create categories.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Category::firstOrCreate([
            'name' => $request->name,
        ]);

        return redirect('/category')->with('msg', 'Category created successfully.');
    }

    public function show($id)
    {
        $category = Category::findOrFail($id);

        $speakers = Speaker::where('category_id', $category->id)
            ->latest()
            ->get();

        $events = Event::with('speaker')
            ->where('category_id', $category->id)
            ->orderBy('start_time', 'asc')
            ->get();

        return view('categories.show', compact('category', 'speakers', 'events'));
    }
}