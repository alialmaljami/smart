@extends('layouts.admin')

@section('title', 'تعديل تصنيف')

@section('content')
    @include('admin.categories.form', ['category' => $category])
@endsection