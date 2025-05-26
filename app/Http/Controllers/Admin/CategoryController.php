<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class CategoryController extends Controller
{
    // public function __construct()
    // {
    //     $this->authorizeResource(Category::class, 'category');
    // }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if (!Gate::allows('categories')) {
            return abort(403, 'Don\'t have Permission');
        }
        $categories = Category::withCount('products')->orderBy('id', $request->order ?? 'DESC')->when(
            $request->search,
            function (Builder $query) use ($request) {
                $query->where('name', 'like', '%' . $request->search . '%');
            }
        )->paginate($request->count ?? 5);

        if ($request->wantsJson()) {
            // get data after added
            $data = view('dashboard.categories._table', compact('categories'))->render();
            return response()->json([
                'msg' => 'All category',
                'data' => $data
            ]);
        }

        return view('dashboard.categories.index', compact('categories'));
    }

      public function create()
    {
        if (Gate::denies('create-category')) {
            return abort(403, 'Don\'t have Permission');
        }
    }

    /**
     * Show the form for creating a new resource.
     */

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $request)
    {
        // Gate::authorize('create-category');
        if (Gate::denies('create-category')) {
            return abort(403, 'Don\'t have Permission');
        }
        // dd($request->all());

        // $data = $request->except('image');

        $name = [
            'en' => $request->name_en,
            'ar' => $request->name_ar,
        ];

        $description = [
            'en' => $request->description_en,
            'ar' => $request->description_ar,
        ];

        // encode => convert array to json
        //JSON_UNESCAPED_UNICODE => Don't turn Arabic into symbols
        $category = Category::create([
            'name' => json_encode($name, JSON_UNESCAPED_UNICODE),
            'description' => json_encode($description, JSON_UNESCAPED_UNICODE),
        ]);

        $path = $request->file('image')->store('uploads', 'custom');

        $category->image()->create([
            'path' => $path
        ]);

        if ($request->wantsJson()) {

            $categories = Category::OrderBy('id', 'DESC')->paginate(5);
            $data = view('dashboard.categories._table', compact('categories'))->render();

            return response()->json([
                'msg' => 'Category created successfully',
                'data' => $data,
            ]);
        }

        // flash()->success('Category created successfully!');
        // return redirect()->route('admin.categories.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Category $category)
    {
        if (Gate::denies('update-category')) {
            return abort(403, 'Don\'t have Permission');
        }

        if ($request->wantsJson()) {
            return response()->json([
                'msg' => 'Category updated successfully',
                'data' => $category
            ]);
        }
        // return view('dashboard.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryRequest $request, Category $category)
    {
        if (Gate::denies('update-category')) {
            return abort(403, 'Don\'t have Permission');
        }
        // $data = $request->except('image');

        $name = [
            'en' => $request->name_en,
            'ar' => $request->name_ar,
        ];

        $description = [
            'en' => $request->description_en,
            'ar' => $request->description_ar,
        ];

        $category->update([
            // 'name' => ''  Mutator
            'name' => json_encode($name, JSON_UNESCAPED_UNICODE),
            'description' => json_encode($description, JSON_UNESCAPED_UNICODE),
        ]);

        if ($request->hasFile('image')) {

            if ($category->image) {
                File::delete('storage/' . $category->image->path);
                $category->image()->delete();
            }
            $path = $request->file('image')->store('uploads', 'custom');
            $category->image()->create([
                'path' => $path,
            ]);
        }

        if ($request->wantsJson()) {
            $category->load('image');
            $categories = Category::OrderBy('id', 'DESC')->paginate(5);
            $data = view('dashboard.categories._table', compact('categories'))->render();

            return response()->json([
                'msg' => 'Category updated successfully',
                'data' => $data,
                'image_path' => asset($category->image_path),
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Category $category)
    {
        Gate::authorize('delete-category');
        //  if (Gate::denies('delete-category')) {
        //     return abort(403, 'Don\'t have Permission');
        // }

        $isDeleted = $category->delete();

        if ($request->wantsJson()) {
            if ($isDeleted) {
                File::delete('storage/' . $category->image->path);
                $categories = Category::orderBy('id', 'DESC')->paginate(5);
                $data = view('dashboard.categories._table', compact('categories'))->render();

                return response()->json([
                    'title' => 'Success',
                    'text' => 'Category Deleted Successfully',
                    'icon' => 'success',
                    'data' => $data
                ], Response::HTTP_OK);
            } else {
                return response()->json([
                    'title' => 'Failed',
                    'text' => 'Category Deletion Failed',
                    'icon' => 'error'
                ], Response::HTTP_BAD_REQUEST);
            }
        }
    }
}
