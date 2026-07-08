@extends('layouts.admin')

@section('title', 'تعديل وسم - لوحة التحكم')

@section('content')
    @include('admin.tags.form', ['tag' => $tag])
@endsection
