<form action="{{ isset($seoMeta) ? route('seo.update', $seoMeta->id) : route('seo.store') }}" method="POST">
    @csrf
    @if(isset($seoMeta))
        @method('PUT')
    @endif

    {{-- 🔹 MODEL TARGET --}}
    <div>
        <label class="block font-medium mb-1">Model Target</label>
        <select name="seoable_type" id="seoable_type"
            class="w-full border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary">
            <option value="">-- Pilih Model --</option>
            @foreach($models as $key => $label)
                <option value="{{ $key }}" {{ old('seoable_type', $seoMeta->seoable_type ?? '') == $key ? 'selected' : '' }}>
                    {{ $label }}
                </option>
            @endforeach
        </select>
        <p class="text-sm text-gray-500 mt-1">Pilih model yang ingin diatur meta-nya (misal: Detail Layanan, Landing, dsb).</p>
    </div>

    {{-- 🔹 MODEL TARGET ID --}}
    <div class="mt-4">
        <label class="block font-medium mb-1">Data Spesifik</label>
        <select name="seoable_id" id="seoable_id"
            class="w-full border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary">
            <option value="">-- Pilih Data --</option>
        </select>
        <p class="text-sm text-gray-500 mt-1">Kosongkan jika ingin meta global untuk semua jenis model ini.</p>
    </div>

    <!-- Basic SEO Section -->
    <div class="mt-8">
        <h2 class="text-xl font-semibold mb-4 text-gray-700 border-b pb-2">Basic SEO Information</h2>

        <x-input label="URL" name="url" value="{{ old('url', $seoMeta->url ?? '') }}" required />
        <x-input label="Title" name="title" value="{{ old('title', $seoMeta->title ?? '') }}" required />
        <x-textarea label="Description" name="description" rows="3">{{ old('description', $seoMeta->description ?? '') }}</x-textarea>
        <x-input label="Keywords" name="keywords" value="{{ old('keywords', $seoMeta->keywords ?? '') }}" placeholder="keyword1, keyword2, keyword3" />

        <div class="grid grid-cols-2 gap-4">
            <x-select label="Robots" name="robots" :options="['index,follow','noindex,follow','index,nofollow','noindex,nofollow']"
                :selected="old('robots', $seoMeta->robots ?? 'index,follow')" />
            <x-input label="Canonical URL" name="canonical_url" type="url" value="{{ old('canonical_url', $seoMeta->canonical_url ?? '') }}" />
        </div>
    </div>

    <!-- Open Graph Section -->
    <div class="mt-8">
        <h2 class="text-xl font-semibold mb-4 text-gray-700 border-b pb-2">Open Graph (Facebook)</h2>

        <x-input label="OG Title" name="og_title" value="{{ old('og_title', $seoMeta->og_title ?? '') }}" />
        <x-textarea label="OG Description" name="og_description" rows="3">{{ old('og_description', $seoMeta->og_description ?? '') }}</x-textarea>

        <div class="grid grid-cols-2 gap-4">
            <x-input label="OG Image URL" name="og_image" type="url" value="{{ old('og_image', $seoMeta->og_image ?? '') }}" />
            <x-input label="OG Image Alt" name="og_image_alt" value="{{ old('og_image_alt', $seoMeta->og_image_alt ?? '') }}" />
        </div>

        <div class="grid grid-cols-2 gap-4">
            <x-select label="OG Type" name="og_type" :options="['website','article','product','video']"
                :selected="old('og_type', $seoMeta->og_type ?? '')" />
            <x-input label="OG URL" name="og_url" type="url" value="{{ old('og_url', $seoMeta->og_url ?? '') }}" />
        </div>

        <div class="grid grid-cols-2 gap-4">
            <x-input label="OG Site Name" name="og_site_name" value="{{ old('og_site_name', $seoMeta->og_site_name ?? '') }}" />
            <x-input label="OG Locale" name="og_locale" value="{{ old('og_locale', $seoMeta->og_locale ?? 'id_ID') }}" />
        </div>
    </div>

    <!-- Twitter Card Section -->
    <div class="mt-8">
        <h2 class="text-xl font-semibold mb-4 text-gray-700 border-b pb-2">Twitter Card</h2>

        <x-select label="Twitter Card Type" name="twitter_card"
            :options="['summary','summary_large_image','app','player']"
            :selected="old('twitter_card', $seoMeta->twitter_card ?? '')" />
        <x-input label="Twitter Title" name="twitter_title" value="{{ old('twitter_title', $seoMeta->twitter_title ?? '') }}" />
        <x-textarea label="Twitter Description" name="twitter_description" rows="3">{{ old('twitter_description', $seoMeta->twitter_description ?? '') }}</x-textarea>
        <x-input label="Twitter Image URL" name="twitter_image" type="url" value="{{ old('twitter_image', $seoMeta->twitter_image ?? '') }}" />
    </div>

    <!-- Author & Publisher Section -->
    <div class="mt-8">
        <h2 class="text-xl font-semibold mb-4 text-gray-700 border-b pb-2">Author & Publisher</h2>
        <div class="grid grid-cols-2 gap-4">
            <x-input label="Author" name="author" value="{{ old('author', $seoMeta->author ?? '') }}" />
            <x-input label="Publisher" name="publisher" value="{{ old('publisher', $seoMeta->publisher ?? '') }}" />
        </div>
    </div>

    <!-- General Visual Meta Section -->
    <div class="mt-8">
        <h2 class="text-xl font-semibold mb-4 text-gray-700 border-b pb-2">Visual Metadata</h2>
        <div class="grid grid-cols-2 gap-4">
            <x-input label="Meta Image (Fallback)" name="meta_image" type="url" value="{{ old('meta_image', $seoMeta->meta_image ?? '') }}" />
            <x-input label="Favicon URL" name="favicon" type="url" value="{{ old('favicon', $seoMeta->favicon ?? '') }}" />
        </div>
    </div>

    <!-- Schema Markup Section -->
    <div class="mt-8">
        <h2 class="text-xl font-semibold mb-4 text-gray-700 border-b pb-2">Schema.org Structured Data</h2>
        <x-textarea label="Schema Markup (JSON-LD)" name="schema_markup" rows="6"
            placeholder='{"@context": "https://schema.org", "@type": "Organization", "name": "Example"}'>{{ old('schema_markup', $seoMeta->schema_markup ?? '') }}</x-textarea>
        <p class="text-gray-600 text-xs mt-1">Enter valid JSON-LD schema markup</p>
    </div>

    <!-- Submit Buttons -->
    <div class="flex items-center justify-between mt-10">
        <button type="submit"
            class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-6 rounded-lg focus:outline-none focus:shadow-outline">
            {{ isset($seoMeta) ? 'Update SEO Meta' : 'Create SEO Meta' }}
        </button>
        <a href="{{ route('seo.index') }}" class="text-gray-600 hover:text-gray-800">Cancel</a>
    </div>
</form>
