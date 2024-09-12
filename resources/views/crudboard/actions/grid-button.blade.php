<div class="btn-group">
  @if($rowAction->isButton())
  <x-aim-admin::crudboard.actions.btn :action="$rowAction"  :$routeParams :$htmlAttributes />
  @else
  <x-aim-admin::crudboard.actions.link :action="$rowAction"  :$routeParams :$htmlAttributes />
  @endif
</div>
