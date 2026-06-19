@extends('layouts.admin')

@section('title', 'تعديل رابط اجتماعي')

@section('content')
    @include('admin.social-links.form', ['socialLink' => $socialLink])
@endsection
