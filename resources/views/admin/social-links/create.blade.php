@extends('layouts.admin')

@section('title', 'إضافة رابط اجتماعي')

@section('content')
    @include('admin.social-links.form', ['socialLink' => null])
@endsection
