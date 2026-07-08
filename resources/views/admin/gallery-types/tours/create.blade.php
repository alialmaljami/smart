@extends('layouts.admin')
@section('title', 'إضافة ' . $config['title_single'])
@section('content')
    @include('admin.gallery-types.tours.form', ['gallery' => null])
@endsection
