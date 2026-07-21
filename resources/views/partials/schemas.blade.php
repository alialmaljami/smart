{{-- Global schemas (always present, rendered directly, not pushed to avoid duplication) --}}
{!! \App\Services\SchemaService::renderSchemas([
    \App\Services\SchemaService::localBusiness(),
    \App\Services\SchemaService::webSite(),
]) !!}
