@extends('seo_metas.layout')

@section('title', 'Edit SEO Meta')

@section('seo_content')
<h1 class="text-2xl font-bold mb-6">Edit SEO Meta</h1>

<form action="{{ route('seo_metas.update', $seoMeta->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    @include('seo_metas.form', ['seoMeta' => $seoMeta])
</form>
@endsection
