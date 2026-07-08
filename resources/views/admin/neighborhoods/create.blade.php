@extends('layouts.admin')
@section('title', 'إضافة حي')
@section('content')
    @include('admin.neighborhoods.form', ['neighborhood' => null])
@endsection
