<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class AdminArticleController extends Controller
{
    use HandlesImageUpload;

    public function index()
    {
        $articles = Article::orderBy('created_at', 'desc')->get();
        return view('admin.articles.index', compact('articles'));
    }

    public function create()
    {
        return view('admin.articles.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'          => 'required|max:200',
            'slug'           => 'nullable|max:200|regex:/^[a-z0-9\-]*$/',
            'content'        => 'required',
            'excerpt'        => 'nullable|max:500',
            'category'       => 'nullable|max:100',
            'tags'           => 'nullable|max:500',
            'author'         => 'nullable|max:100',
            'meta_title'     => 'nullable|max:70',
            'meta_desc'      => 'nullable|max:165',
            'meta_keywords'  => 'nullable|max:500',
            'published_at'   => 'nullable|date',
            'is_published'   => 'boolean',
            'show_toc'       => 'boolean',
            'image'          => 'nullable|image|max:5120',
            'og_image'       => 'nullable|image|max:5120',
            'faqs'           => 'nullable|array',
            'faqs.*.q'       => 'nullable|string|max:500',
            'faqs.*.a'       => 'nullable|string|max:2000',
            'cta_text'       => 'nullable|max:100',
            'cta_url'        => 'nullable|max:500',
            'cta_type'       => 'nullable|in:wa,url',
        ]);

        // Slug
        $slug = !empty($validated['slug']) ? Str::slug($validated['slug']) : Str::slug($validated['title']);
        $base = $slug; $i = 1;
        while (Article::where('slug', $slug)->exists()) { $slug = $base . '-' . $i++; }
        $validated['slug'] = $slug;

        $validated['is_published'] = $request->boolean('is_published');
        $validated['show_toc']     = $request->boolean('show_toc');
        $validated['published_at'] = $validated['published_at'] ?? ($validated['is_published'] ? now() : null);
        $validated['tags']         = $validated['tags'] ? array_filter(array_map('trim', explode(',', $validated['tags']))) : null;
        $validated['excerpt']      = $validated['excerpt'] ?: Str::limit(strip_tags($validated['content']), 160);

        // Auto SEO
        if (empty($validated['meta_title'])) $validated['meta_title'] = Str::limit($validated['title'], 55) . ' | ' . Setting::get('company_name', config('app.name'));
        if (empty($validated['meta_desc']))  $validated['meta_desc']  = Str::limit(strip_tags($validated['excerpt']), 155);

        // FAQs
        $faqs = [];
        if (!empty($request->faqs)) {
            foreach ($request->faqs as $faq) {
                if (!empty($faq['q']) || !empty($faq['a'])) {
                    $faqs[] = ['q' => $faq['q'] ?? '', 'a' => $faq['a'] ?? ''];
                }
            }
        }
        $validated['faqs'] = !empty($faqs) ? $faqs : null;

        // CTA
        $validated['cta_button'] = !empty($request->cta_text) ? [
            'text' => $request->cta_text,
            'url'  => $request->cta_url ?? '',
            'type' => $request->cta_type ?? 'url',
        ] : null;

        // Images
        if ($request->hasFile('image')) {
            $validated['image']    = $this->storeWebP($request->file('image'), 'articles', 1200, 630);
            $validated['alt_text'] = $validated['alt_text'] ?? $validated['title'];
            if (!$request->hasFile('og_image')) {
                $validated['og_image'] = $this->storeOgWebP($request->file('image'), 'articles/og');
            }
        }
        if ($request->hasFile('og_image')) {
            $validated['og_image'] = $this->storeOgWebP($request->file('og_image'), 'articles/og');
        }

        unset($validated['cta_text'], $validated['cta_url'], $validated['cta_type']);
        Article::create($validated);
        return redirect()->route('admin.articles.index')->with('success', 'Artikel berhasil ditambahkan.');
    }

    public function edit(Article $article)
    {
        return view('admin.articles.edit', compact('article'));
    }

    public function update(Request $request, Article $article)
    {
        $validated = $request->validate([
            'title'          => 'required|max:200',
            'slug'           => 'nullable|max:200|regex:/^[a-z0-9\-]*$/',
            'content'        => 'required',
            'excerpt'        => 'nullable|max:500',
            'category'       => 'nullable|max:100',
            'tags'           => 'nullable|max:500',
            'author'         => 'nullable|max:100',
            'meta_title'     => 'nullable|max:70',
            'meta_desc'      => 'nullable|max:165',
            'meta_keywords'  => 'nullable|max:500',
            'published_at'   => 'nullable|date',
            'is_published'   => 'boolean',
            'show_toc'       => 'boolean',
            'image'          => 'nullable|image|max:5120',
            'og_image'       => 'nullable|image|max:5120',
            'faqs'           => 'nullable|array',
            'faqs.*.q'       => 'nullable|string|max:500',
            'faqs.*.a'       => 'nullable|string|max:2000',
            'cta_text'       => 'nullable|max:100',
            'cta_url'        => 'nullable|max:500',
            'cta_type'       => 'nullable|in:wa,url',
        ]);

        // Slug
        if (!empty($validated['slug'])) {
            $slug = Str::slug($validated['slug']);
            $base = $slug; $i = 1;
            while (Article::where('slug', $slug)->where('id', '!=', $article->id)->exists()) { $slug = $base . '-' . $i++; }
            $validated['slug'] = $slug;
        }

        $validated['is_published'] = $request->boolean('is_published');
        $validated['show_toc']     = $request->boolean('show_toc');
        $validated['published_at'] = $validated['published_at'] ?? ($validated['is_published'] && !$article->published_at ? now() : $article->published_at);
        $validated['tags']         = $validated['tags'] ? array_filter(array_map('trim', explode(',', $validated['tags']))) : null;

        // FAQs
        $faqs = [];
        if (!empty($request->faqs)) {
            foreach ($request->faqs as $faq) {
                if (!empty($faq['q']) || !empty($faq['a'])) {
                    $faqs[] = ['q' => $faq['q'] ?? '', 'a' => $faq['a'] ?? ''];
                }
            }
        }
        $validated['faqs'] = !empty($faqs) ? $faqs : null;

        // CTA
        $validated['cta_button'] = !empty($request->cta_text) ? [
            'text' => $request->cta_text,
            'url'  => $request->cta_url ?? '',
            'type' => $request->cta_type ?? 'url',
        ] : null;

        // Images
        if ($request->hasFile('image')) {
            $this->deleteStorageFile($article->image);
            $validated['image'] = $this->storeWebP($request->file('image'), 'articles', 1200, 630);
            if (!$request->hasFile('og_image') && !$article->og_image) {
                $validated['og_image'] = $this->storeOgWebP($request->file('image'), 'articles/og');
            }
        }
        if ($request->hasFile('og_image')) {
            $this->deleteStorageFile($article->og_image);
            $validated['og_image'] = $this->storeOgWebP($request->file('og_image'), 'articles/og');
        }

        unset($validated['cta_text'], $validated['cta_url'], $validated['cta_type']);
        $article->update($validated);
        return redirect()->route('admin.articles.index')->with('success', 'Artikel berhasil diperbarui.');
    }

    public function destroy(Article $article)
    {
        $this->deleteStorageFile($article->image);
        $this->deleteStorageFile($article->og_image);
        $article->delete();
        return back()->with('success', 'Artikel berhasil dihapus.');
    }
}
