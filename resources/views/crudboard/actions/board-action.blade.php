@php $routeParams = $crudAction->getRouteParameters(); @endphp
@if($crudAction->isButton())
<x-aim-admin::crudboard.actions.btn :action="$crudAction" :$routeParams :$htmlAttributes />
@else
<x-aim-admin::crudboard.actions.link :action="$crudAction" :$routeParams :$htmlAttributes />
@endif
