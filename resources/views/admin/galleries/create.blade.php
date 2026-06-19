@extends('layouts.admin')

@section('title', 'إضافة صورة')

@section('content')
    @include('admin.galleries.form', ['gallery' => null])
@endsection