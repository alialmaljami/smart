@extends('layouts.admin')

@section('title', 'تعديل مادة')

@section('content')
    @include('admin.materials.form', ['material' => $material])
@endsection
