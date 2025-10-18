# 🧠 Nixie SEO for Laravel

Paket SEO lengkap untuk Laravel — kelola **Meta Tags**, **Open Graph**, **Twitter Cards**, dan **Structured Data** dengan mudah dan otomatis.

---

## 📌 Fitur

- Meta Title, Description, Keywords  
- Canonical URL  
- Open Graph (Facebook, LinkedIn)  
- Twitter Cards  
- Polymorphic relationship → bisa dipasang di model apapun  
- Auto Meta Injection di Blade  
- Artisan commands (coming soon)  

---

## 🚀 Instalasi

```bash
composer require nixie-seo/seo
```

### Publikasikan aset
```bash
php artisan vendor:publish --provider="Nixie\Seo\SeoServiceProvider" --tag=seo-migrations
php artisan vendor:publish --provider="Nixie\Seo\SeoServiceProvider" --tag=seo-views
php artisan migrate
```

---

## ⚙️ Konfigurasi

Tambahkan relasi `morphOne` di model yang ingin memiliki metadata SEO.

```php
use Nixie\Seo\Models\SeoMeta;

class Post extends Model
{
    public function seoMeta()
    {
        return $this->morphOne(SeoMeta::class, 'seoable');
    }
}
```

---

## 📝 Penggunaan di Controller

### Menyimpan SEO Meta saat membuat model
```php
use Nixie\Seo\Models\SeoMeta;

public function store(Request $request)
{
    $post = Post::create($request->all());

    $post->seoMeta()->create([
        'meta_title' => $request->meta_title,
        'meta_description' => $request->meta_description,
        'meta_keywords' => $request->meta_keywords,
        'canonical_url' => $request->canonical_url,
    ]);
}
```

### Update SEO Meta
```php
$post->seoMeta()->updateOrCreate(
    ['seoable_id' => $post->id, 'seoable_type' => Post::class],
    [
        'meta_title' => $request->meta_title,
        'meta_description' => $request->meta_description,
        'meta_keywords' => $request->meta_keywords,
    ]
);
```

---

## 🧩 Blade Form (opsional)

Gunakan partial form yang disediakan paket:

```blade
@include('seo::form', ['seo' => $model->seoMeta])
```

Form ini menampilkan input:

- Meta Title  
- Meta Description  
- Meta Keywords  
- Canonical URL  

---

## 🌐 Auto Meta Injection di Layout

Di layout utama (`layouts/app.blade.php`):

```blade
{!! seo()->for($model) !!}
```

Hasilnya otomatis generate semua meta tag, termasuk Open Graph & Twitter Card:

```html
<title>Judul Post</title>
<meta name="description" content="Deskripsi Post...">
<meta property="og:title" content="Judul Post">
<meta property="og:description" content="Deskripsi Post...">
<meta name="twitter:card" content="summary_large_image">
<link rel="canonical" href="https://example.com/post/slug">
```

---

## 📂 Contoh Penggunaan Lengkap

### Controller
```php
$post = Post::find(1);

// Update SEO
$post->seoMeta()->updateOrCreate([], [
    'meta_title' => 'Judul SEO',
    'meta_description' => 'Deskripsi SEO',
    'meta_keywords' => 'seo, laravel, package',
    'canonical_url' => url()->current(),
]);
```

### Blade
```blade
<html>
<head>
    {!! seo()->for($post) !!}
</head>
<body>
    <h1>{{ $post->title }}</h1>
</body>
</html>
```

---

## 🧰 Perintah Artisan (Coming Soon)

- `php artisan seo:generate` → generate meta otomatis untuk semua model  
- `php artisan seo:clean` → hapus meta yang tidak terpakai  

---

## 🔧 Konfigurasi Tambahan

Buat file `config/seo.php` (jika ingin override default):

```php
return [
    'default_title' => env('APP_NAME', 'Laravel'),
    'default_description' => 'Deskripsi default website',
    'default_keywords' => 'laravel, seo, package',
    'default_image' => '/images/default-og.png',
];
```

---

## 📄 Lisensi

Lisensi [MIT](LICENSE)

---

**Dikembangkan oleh Nixie Team**  
📧 support@nixie.dev

