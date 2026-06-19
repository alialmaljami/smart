@extends('layouts.admin')

@section('title', 'إضافة معلومات اتصال')

@section('content')
    @include('admin.contacts.form', ['contact' => null])
@endsection
