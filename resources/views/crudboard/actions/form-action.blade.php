@php $routeParams = $action->getRouteParameters(); @endphp
@if($action->isButton())
<x-aim-admin::crudboard.actions.btn :$action :$routeParams :htmlAttributes="$htmlActionAttributes" />
@else
<x-aim-admin::crudboard.actions.link :$action :$routeParams :htmlAttributes="$htmlActionAttributes" />
@endif
