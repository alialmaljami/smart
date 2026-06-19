@extends('layouts.admin')

@section('title', 'إضافة تصنيف')

@section('content')
    @include('admin.categories.form', ['category' => null])
@endsection