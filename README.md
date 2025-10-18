# 🧠 Nixie SEO for Laravel

Paket SEO lengkap untuk Laravel — kelola **Meta Tags**, **Open Graph**, **Twitter Cards**, dan **Structured Data** secara otomatis.

---

## 🚀 Instalasi

```bash
composer require nixie-seo/seo
```

### Publikasikan aset
```bash
php artisan vendor:publish --provider="Nixie\Seo\SeoServiceProvider" --tag=seo-migrations
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

---

## 🧩 Blade Form (opsional)

```blade
@include('seo-metas.form', ['seo' => $model->seoMeta])
```

Form di atas akan menampilkan input meta title, description, dan keywords.

---

## 🌐 Auto Meta Injection (opsional)

Di layout utama (`layouts/app.blade.php`), tambahkan:
```blade
{!! seo()->for($model) !!}
```

Akan otomatis menampilkan semua tag SEO sesuai model.

---

## 🧰 Perintah Artisan (Coming Soon)

- `php artisan seo:generate` → menghasilkan tag meta secara otomatis
- `php artisan seo:clean` → hapus data meta yang tidak terpakai

---

## 📄 Lisensi

Lisensi [MIT](LICENSE)

---

**Dikembangkan oleh Nixie Team**  
📧 support@nixie.dev
