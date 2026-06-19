@extends('layouts.admin')

@section('title', 'تعديل خدمة')

@section('content')
    @include('admin.services.form', ['service' => $service])
@endsection
