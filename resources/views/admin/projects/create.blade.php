@extends('layouts.admin')

@section('title', 'إضافة مشروع جديد')

@section('content')
    @include('admin.projects.form', ['project' => null])
@endsection
