@extends('layouts.admin')
@section('title', 'تعديل ' . $config['title_single'])
@section('content')
    @include('admin.gallery-types.before-after.form', ['gallery' => $gallery])
@endsection
