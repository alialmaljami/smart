@extends('layouts.admin')

@section('title', 'إضافة خدمة جديدة')

@section('content')
    @include('admin.services.form', ['service' => null])
@endsection
