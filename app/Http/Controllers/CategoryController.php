<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Restrict category management to admins only
     */
    private function blockNormalUsers(): void
    {
        if (!auth()->user()->is_admin) {

            abort(
                403,
                'Only admins can manage categories.'
            );
        }
    }

    /**
     * Shared validation rules for category forms
     */
    private function validationRules(): array
    {
        return [

            'name' => [
                'required',
                'string',
                'max:255',
            ],
        ];
    }

    /**
     * Display all conference categories
     */
    public function index()
    {
        $categories = Category::latest()
            ->paginate(5);

        return view(
            'categories.index',
            compact('categories')
        );
    }

    /**
     * Show category creation form
     */
    public function create()
    {
        // Authorization check
        $this->blockNormalUsers();

        return view('categories.create');
    }

    /**
     * Store newly created category
     */
    public function store(Request $request)
    {
        // Authorization check
        $this->blockNormalUsers();

        // Validate incoming data
        $validated = $request->validate(
            $this->validationRules()
        );

        // Prevent duplicate category creation
        Category::firstOrCreate([

            'name' => $validated['name'],
        ]);

        return redirect('/category')
            ->with(
                'msg',
                'Category created successfully.'
            );
    }

    /**
     * Display selected category details
     */
    public function show(Category $category)
    {
        // Related speakers
        $speakers = $category->speakers()
            ->latest()
            ->paginate(5);

        // Related conference sessions
        $events = $category->events()
            ->with('speaker')
            ->orderBy('start_time', 'asc')
            ->paginate(5);

        return view(
            'categories.show',
            compact(
                'category',
                'speakers',
                'events'
            )
        );
    }
}