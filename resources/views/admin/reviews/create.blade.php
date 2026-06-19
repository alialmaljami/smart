@extends('layouts.admin')
@section('title', 'إضافة تقييم جديد')
@section('content')
    @include('admin.reviews.form', ['review' => null])
@endsection