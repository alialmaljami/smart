@extends('layouts.admin')
@section('title', 'تعديل ' . $config['title_single'])
@section('content')
    @include('admin.gallery-types.photography.form')
@endsection
