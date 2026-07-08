@extends('layouts.admin')
@section('title', 'تعديل الحي')
@section('content')
    @include('admin.neighborhoods.form', ['neighborhood' => $neighborhood])
@endsection
