@extends('layouts.admin')

@section('title', 'إضافة مادة جديدة')

@section('content')
    @include('admin.materials.form', ['material' => null])
@endsection
