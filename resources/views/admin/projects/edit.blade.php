@extends('layouts.admin')

@section('title', 'تعديل مشروع')

@section('content')
    @include('admin.projects.form', ['project' => $project])
@endsection
