@extends('layouts.admin')
@section('title', 'إضافة ' . $config['title_single'])
@section('content')
    @include('admin.gallery-types.before-after.form', ['gallery' => null])
@endsection
