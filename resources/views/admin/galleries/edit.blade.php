@extends('layouts.admin')

@section('title', 'تعديل الصورة')

@section('content')
    @include('admin.galleries.form', ['gallery' => $gallery])
@endsection