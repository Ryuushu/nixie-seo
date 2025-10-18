<?php

namespace Nixie\Seo\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SeoController extends Controller
{
    /**
     * Tampilkan daftar data SEO.
     */
    public function index()
    {
        $seoMetas = DB::table('seo_metas')
            ->orderByDesc('created_at')
            ->paginate(15);

        return view('seo::index', compact('seoMetas'));
    }

    /**
     * Form tambah SEO meta baru.
     */
    public function create()
    {
        $models = $this->getModelOptions();

        return view('seo::form', [
            'models' => $models,
            'seoMeta' => null,
        ]);
    }

    /**
     * Simpan data SEO meta baru.
     */
    public function store(Request $request)
    {
        $validated = $this->validateSeoData($request);

        DB::table('seo_metas')->insert(array_merge($validated, [
            'created_at' => now(),
            'updated_at' => now(),
        ]));

        return redirect()->route('seo.index')->with('success', 'SEO meta berhasil dibuat.');
    }

    /**
     * Form edit SEO meta.
     */
    public function edit($id)
    {
        $seoMeta = DB::table('seo_metas')->where('id', $id)->first();

        if (!$seoMeta) {
            return redirect()->route('seo.index')->with('error', 'Data SEO meta tidak ditemukan.');
        }

        $models = $this->getModelOptions();

        return view('seo::form', compact('seoMeta', 'models'));
    }

    /**
     * Update SEO meta.
     */
    public function update(Request $request, $id)
    {
        $validated = $this->validateSeoData($request);

        DB::table('seo_metas')->where('id', $id)->update(array_merge($validated, [
            'updated_at' => now(),
        ]));

        return redirect()->route('seo.index')->with('success', 'SEO meta berhasil diperbarui.');
    }

    /**
     * Hapus SEO meta.
     */
    public function destroy($id)
    {
        DB::table('seo_metas')->where('id', $id)->delete();

        return redirect()->route('seo.index')->with('success', 'SEO meta berhasil dihapus.');
    }

    /**
     * 🔹 Helper: Validasi data SEO
     */
    private function validateSeoData(Request $request)
    {
        return $request->validate([
            'seoable_type' => 'nullable|string|max:255',
            'seoable_id' => 'nullable|integer',
            'url' => 'required|string|max:500',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'keywords' => 'nullable|string|max:500',
            'robots' => 'nullable|string|max:100',
            'canonical_url' => 'nullable|url|max:500',
            'og_title' => 'nullable|string|max:255',
            'og_description' => 'nullable|string|max:500',
            'og_image' => 'nullable|url|max:500',
            'og_image_alt' => 'nullable|string|max:255',
            'og_type' => 'nullable|string|max:100',
            'og_url' => 'nullable|url|max:500',
            'og_site_name' => 'nullable|string|max:255',
            'og_locale' => 'nullable|string|max:50',
            'twitter_card' => 'nullable|string|max:100',
            'twitter_title' => 'nullable|string|max:255',
            'twitter_description' => 'nullable|string|max:500',
            'twitter_image' => 'nullable|url|max:500',
            'author' => 'nullable|string|max:255',
            'publisher' => 'nullable|string|max:255',
            'meta_image' => 'nullable|url|max:500',
            'favicon' => 'nullable|url|max:500',
            'schema_markup' => 'nullable|json',
        ]);
    }

    /**
     * 🔹 Helper: Pilihan model target (bisa diatur sesuai kebutuhan)
     */
    private function getModelOptions()
    {
        return [
            'App\\Models\\Service' => 'Layanan',
            'App\\Models\\Article' => 'Artikel',
            'App\\Models\\Page' => 'Halaman',
            'App\\Models\\Landing' => 'Landing Page',
        ];
    }

    /**
     * 🔹 (Opsional) AJAX endpoint: ambil data berdasarkan model
     * Untuk mengisi dropdown "Data Spesifik"
     */
    public function getModelItems(Request $request)
    {
        $modelClass = $request->input('seoable_type');

        if (!class_exists($modelClass)) {
            return response()->json([]);
        }

        $items = app($modelClass)::select('id', DB::raw('title as name'))
            ->limit(100)
            ->get();

        return response()->json($items);
    }
}
