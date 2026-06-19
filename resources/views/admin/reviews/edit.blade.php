@extends('layouts.admin')
@section('title', 'تعديل تقييم')
@section('content')
    @include('admin.reviews.form', ['review' => $review])
@endsection