<div class="{{$field->getCssClass()}}" {!! $htmlAttributes !!}>
    @foreach ( $field->getCustomOption('children') as $key=>$child)
        @php
            if($dependant = $child->getCustomOption('dependant')){
                $child->setHtmlAttribute('onchange',"loadDependant(this,'$dependant')");
             }
             $htmlAttributes = $child->getAttributesAsHtml() ;
        @endphp
        <div class="{{$child->getLayoutClass() }}">
            <x-dynamic-component :component="$child->getComponent()" :field="$child" :$htmlAttributes/>
        </div>
    @endforeach
</div>

@if($field->getHelp())
    <span class="text-xs">{!! $field->getHelp() !!}</span>
@endif

<x-aim-admin::alert.inline-validation-error :errors="$errors->get($field->getName())" class="mt-1"/>

@pushOnce('scripts')
    <script type="module">
        window.loadDependant = (el, dependant) => {
            swal.fire({
                html: 'loading...',
                allowOutsideClick: false,
                didOpen: () => {
                    swal.showLoading()
                },
            });
            const depel = $("select[data-chain-select='" + dependant + "']");
            $.post({
                url: "{{route($field->getCustomOption('dependant-route')) }}",
                data: {type: $(el).attr('name'), value: $(el).val(), _token: "{{ csrf_token() }}"},
                success: function (rt) {
                    $(depel).find("option[value!='']").remove();
                    $.each(rt, function (key, item) {
                        $(depel).append("<option value='" + item.key + "'>" + item.value + "</option>");
                    });
                    swal.close();
                }
            });
            // alert($("select[data-chain-select='"+dependant+"']").val());
            // alert($(el).val());
        }
    </script>
@endPushOnce
