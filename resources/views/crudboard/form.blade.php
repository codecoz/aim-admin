<!-- Content-->
<div class="content">
    <div class="card mb-3">
        <div class="card-header">
            <h5 class="card-title mb-0">
                @if($form->getTitle() )
                    {{$form->getTitle() }}
                @else
                    {{ $attributes['title'] }}
                @endif
            </h5>
        </div>
        <div class="card-body">
            <div id="alert"></div>
            @include('aim-admin::alert.validation-error')
            <form name="{{$form->getName()}}" action="{{$form->getActionUrl()}}" method="{{$form->getMethod()}}"
                  class="{{$form->getCssClass()}}" {{ $form->getAttributesAsHtml() }}
                  @if($form->getFields()->hasFileInput())
                      enctype="multipart/form-data"
                @endif
            >
                <div class="row">
                    @foreach($form->getFields() as $field)
                        @php $htmlAttributes = $field->getAttributesAsHtml() ; @endphp

                        @if($field->isHiddenInput())
                            <x-dynamic-component :component="$field->getComponent()" :$field :$htmlAttributes/>
                        @else
                            <div class="form-group {{$field->getLayoutClass() }}">
                                <x-dynamic-component :component="$field->getComponent()" :$field :$htmlAttributes/>
                            </div>
                        @endif
                    @endforeach
                    @csrf
                </div>

                <div class="flex">
                    @foreach($form->getActions()->getFormActions() as $action)
                        @if($action->shouldBeDisplayedFor(null))
                            @php $htmlActionAttributes = $action->getAttributesAsHtml() ; @endphp
                            <x-dynamic-component :component="$action->getComponent()" :$action :$htmlActionAttributes/>
                        @endif
                    @endforeach
                </div>
            </form>
        </div>
    </div>
</div>
