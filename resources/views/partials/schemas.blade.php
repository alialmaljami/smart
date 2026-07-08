@php
    $schemas = [];
    $schemas[] = \App\Services\SchemaService::localBusiness();
    $schemas[] = \App\Services\SchemaService::webSite();
    if (isset($breadcrumbs) && count($breadcrumbs)) {
        $schemas[] = \App\Services\SchemaService::breadcrumbList($breadcrumbs);
    }
@endphp
@push('schema')
{!! \App\Services\SchemaService::renderSchemas($schemas) !!}
@endpush
