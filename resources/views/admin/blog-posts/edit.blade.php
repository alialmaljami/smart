@extends('layouts.admin')

@section('title', 'تعديل مقال')

@section('content')
    @include('admin.blog-posts.form', ['post' => $blogPost])
@endsection
