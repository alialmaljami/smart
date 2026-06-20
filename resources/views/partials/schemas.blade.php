@php
    $schemas = [];
    $schemas[] = \App\Services\SchemaService::localBusiness();
    if (isset($breadcrumbs) && count($breadcrumbs)) {
        $schemas[] = \App\Services\SchemaService::breadcrumbList($breadcrumbs);
    }
@endphp
@push('schema')
{!! \App\Services\SchemaService::renderSchemas($schemas) !!}
@endpush
