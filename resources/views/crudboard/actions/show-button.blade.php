@php
    $routeParams = $action->getRouteParameters();
    $htmlAttributes = $action->getAttributesAsHtml();
@endphp
@if($action->isButton())
    <x-aim-admin::crudboard.actions.btn :$action :$routeParams :$htmlAttributes/>
@else
    <x-aim-admin::crudboard.actions.link :$action :$routeParams :$htmlAttributes/>
@endif
