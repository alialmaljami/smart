@extends('layouts.admin')
@section('title', 'إضافة ' . $config['title_single'])
@section('content')
    @include('admin.gallery-types.photography.form')
@endsection
