@extends('layouts.admin')

@section('title', 'تعديل معلومات اتصال')

@section('content')
    @include('admin.contacts.form', ['contact' => $contact])
@endsection
