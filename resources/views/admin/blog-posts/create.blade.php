@extends('layouts.admin')

@section('title', 'إضافة مقال جديد')

@section('content')
    @include('admin.blog-posts.form', ['post' => null])
@endsection
