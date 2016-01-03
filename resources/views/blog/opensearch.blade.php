<?xml version="1.0" encoding="UTF-8"?>
<OpenSearchDescription xmlns="http://a9.com/-/spec/opensearch/1.1/" xmlns:moz="http://www.mozilla.org/2006/browser/search/">
    <ShortName>{{ config('larablog.site_name' )}}</ShortName>
    <Description>Search {{ config('larablog.site_name') }}</Description>
    <Image height="16" width="16" type="image/x-icon">{{ config('app.url') }}/favicon.ico</Image>
    <Url type="text/html" method="get" template="{{ config('app.url') . config('site.search_path') }}?q={searchTerms}" />
</OpenSearchDescription>