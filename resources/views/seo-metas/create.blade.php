@extends('seo_metas.layout')

@section('title', 'Tambah SEO Meta')

@section('seo_content')
<h1 class="text-2xl font-bold mb-6">Tambah SEO Meta</h1>

<form action="{{ route('seo_metas.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @include('seo_metas.form', ['seoMeta' => null])
</form>
@endsection
