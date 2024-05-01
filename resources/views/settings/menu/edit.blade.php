<x-aimadmin::layout.main>
    <div class="content">
        <div class="card mb-3">
            <div class="card-header ui-sortable-handle">
                <h3 class="card-title">
                    <i class="fa-solid fa-gear"></i>
                    Edit menu
                </h3>
                <div class="card-tools">
                    <ul class="nav nav-pills ml-auto">
                        <li class="nav-item">
                            <a href="{{route('menu_list')}}"
                               class="btn btn-primary end">
                                <i class="fas fa-arrow-left"></i>
                                Back
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="card-body">
                <form name="menu_form" action={{ route('menu_update') }} method="post">
                    @csrf
                    <input type="hidden" name="id" value="{{ $menu->id }}"/>
                    <input type="hidden" name="applicationID" value="{{$menu->applicationID}}">

                    <div class="mb-3">
                        <label class="form-label" for="title">Title</label>
                        <input class="form-control  " id="title" name="title" type="text" placeholder="Title"
                               value="{{ $menu->title }}"/>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="title">Slug</label>
                        <input class="form-control  " id="name" name="name" type="text" placeholder="name"
                               value="{{ $menu->name }}"/>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="parentID">Parent ID</label>
                        <select class="form-control" name="parentID" id="parentID">
                            @php $isMatchFound = false; @endphp
                            @foreach ($all_menu as $item)
                                @php if ($item['id'] == old('parentID', $menu->parentID)) $isMatchFound = true; @endphp
                                <option
                                    value="{{ $item['id'] }}" {{ $item['id'] == old('parentID', $menu->parentID) ? 'selected' : '' }}>
                                    {{ $item['title'] }}
                                </option>
                            @endforeach
                            <option value="-1" {{ !$isMatchFound ? 'selected' : '' }}>None</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="display_order">Display Order</label>
                        <input class="form-control  " id="display_order" name="display_order" type="number"
                               value="{{ $menu->displayOrder }}"/>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="iconName">Icon Name</label>
                        <select class="form-control icons_select2" name="iconName" id="iconName">
                            @foreach ($icons as $icon)
                                <option
                                    value="{{ $icon }}" {{ $icon == old('iconName', $menu->iconName) ? 'selected' : '' }}
                                >
                                    {{ $icon }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="target">Target</label>
                        <select class="form-control" name="target" id="target">
                            @foreach ($targets as $key => $target)
                                <option
                                    value="{{ $key }}" {{ $target == old('target', $menu->target) ? 'selected' : '' }}
                                >
                                    {{ $target }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex">
                        <button class="btn btn-primary  float-right" type="submit" value="submit">Submit</button>
                        <a href="{{ route('menu_list') }}" class="btn btn-secondary"> Cancel</a>
                    </div>

                </form>

            </div>
        </div>
    </div>

    @push('scripts')
        <script type="module">
            $(document).ready(function () {
                // Function to format icons in the dropdown
                function formatIcon(option) {
                    // Check if the option has a value, to avoid errors on placeholder items
                    if (!option.id) return option.text; // return the text for placeholder items

                    // Create and return the formatted option with icon
                    return $(`<span><i class="fa fa-${option.element.value}"></i> ${option.text}</span>`);
                }

                // Initialize Select2 with icon formatting
                $('.icons_select2').select2({
                    width: '100%', // Ensures the dropdown takes the full width of its container
                    templateSelection: formatIcon, // Use the formatIcon function for selected items
                    templateResult: formatIcon // Use the same function for dropdown items
                });
            });
        </script>
    @endpush
</x-aimadmin::layout.main>

