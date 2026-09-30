<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ServiceCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class AdminServiceCategoryController extends Controller
{
    public function index()
    {
        $categories = ServiceCategory::withCount(['services'])->latest()->get();
        return view('admin.service_categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.service_categories.form', ['category' => null]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'          => 'required|string|max:255',
            'slug'          => 'nullable|string|max:255|unique:service_categories,slug',
            'description'   => 'nullable|string',
            'image'         => 'nullable|image|max:2048',
            'meta_title'    => 'nullable|string|max:255',
            'meta_desc'     => 'nullable|string',
            'meta_keywords' => 'nullable|string|max:500',
        ]);

        $data = $request->only(['name', 'description', 'meta_title', 'meta_desc', 'meta_keywords']);
        $data['slug'] = $request->slug ?: Str::slug($request->name);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('categories', 'public');
        }

        ServiceCategory::create($data);

        return redirect()->route('admin.service-categories.index')
            ->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function edit(ServiceCategory $serviceCategory)
    {
        return view('admin.service_categories.form', ['category' => $serviceCategory]);
    }

    public function update(Request $request, ServiceCategory $serviceCategory)
    {
        $request->validate([
            'name'          => 'required|string|max:255',
            'slug'          => 'nullable|string|max:255|unique:service_categories,slug,' . $serviceCategory->id,
            'description'   => 'nullable|string',
            'image'         => 'nullable|image|max:2048',
            'meta_title'    => 'nullable|string|max:255',
            'meta_desc'     => 'nullable|string',
            'meta_keywords' => 'nullable|string|max:500',
        ]);

        $data = $request->only(['name', 'description', 'meta_title', 'meta_desc', 'meta_keywords']);
        $data['slug'] = $request->slug ?: Str::slug($request->name);

        if ($request->hasFile('image')) {
            if ($serviceCategory->image) {
                Storage::disk('public')->delete($serviceCategory->image);
            }
            $data['image'] = $request->file('image')->store('categories', 'public');
        }

        $serviceCategory->update($data);

        return redirect()->route('admin.service-categories.index')
            ->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy(ServiceCategory $serviceCategory)
    {
        if ($serviceCategory->image) {
            Storage::disk('public')->delete($serviceCategory->image);
        }
        $serviceCategory->delete();

        return redirect()->route('admin.service-categories.index')
            ->with('success', 'Kategori berhasil dihapus.');
    }
}
