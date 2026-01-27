<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CmsPage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;

class CmsPageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pages = CmsPage::latest()->paginate(10);
        return view('admin.cms.pages.index', compact('pages'));
    }

    public function create()
    {
        return view('admin.cms.pages.form', [
            'page' => new CmsPage(),
            'isEdit' => false
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:cms_pages,slug',
            'content' => 'nullable|string',
            'template' => 'nullable|string',
            'is_active' => 'boolean',
            'meta_description' => 'nullable|string|max:255',
            'meta_keywords' => 'nullable|string|max:255',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        CmsPage::create($validated);

        Cache::forget('custom_pages_list');

        return redirect()->route('admin.cms.pages.index')->with('success', 'Page created successfully.');
    }

    public function edit(CmsPage $cmsPage)
    {
        return view('admin.cms.pages.form', [
            'page' => $cmsPage,
            'isEdit' => true
        ]);
    }

    public function update(Request $request, CmsPage $cmsPage)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:cms_pages,slug,' . $cmsPage->id,
            'content' => 'nullable|string',
            'template' => 'nullable|string',
            'is_active' => 'boolean',
            'meta_description' => 'nullable|string|max:255',
            'meta_keywords' => 'nullable|string|max:255',
        ]);

        $cmsPage->update($validated);

        Cache::forget("cms_page_{$cmsPage->slug}");
        Cache::forget('custom_pages_list');

        return redirect()->route('admin.cms.pages.index')->with('success', 'Page updated successfully.');
    }

    public function destroy(CmsPage $cmsPage)
    {
        $slug = $cmsPage->slug;
        $cmsPage->delete();

        Cache::forget("cms_page_{$slug}");
        Cache::forget('custom_pages_list');

        return redirect()->route('admin.cms.pages.index')->with('success', 'Page deleted successfully.');
    }
}
