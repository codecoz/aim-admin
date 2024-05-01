<x-aimadmin::layout.main>
    <div class="content">
        <div class="card mb-3">
            <div class="card-header ui-sortable-handle">
                <h3 class="card-title">
                    <i class="fa-solid fa-gear"></i>
                    Edit Menu Permission <b>[{{$role->title}}]</b>
                </h3>
                <div class="card-tools">
                    <ul class="nav nav-pills ml-auto">
                        <li class="nav-item">
                            <a href="{{route('role_list')}}"
                               class="btn btn-primary end">
                                <i class="fas fa-arrow-left"></i>
                                Back
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="card-body">
                    <form name="role_form" action={{ route('role_update') }} method="post">

                        @csrf

                        <input type="hidden" name="id" value="{{ $role->id }}"/>
                        <input type="hidden" name="applicationID" value="{{$role->applicationID}}">
                        <input class="form-control" id="title" name="title" type="hidden" placeholder="Title"
                               value="{{ $role->title }}"/>
                        <input class="form-control" id="shortDescription" name="shortDescription" type="hidden"
                               value="{{ $role->shortDescription }}"/>

                        <div class="form-group">
                            <label for="menus">Menu:</label>
                            @foreach ($menus as $menu)
                                @if ($menu['parentID'] == 0)
                                    <div class="menu-container">
                                        <ul>
                                            @include('aimadmin::settings.menu.item', [
                                                'menu' => $menu,
                                                'menus' => $menus,
                                                'role' => $role,
                                            ])
                                        </ul>
                                    </div>
                                @endif
                            @endforeach
                        </div>

                        <div class="flex">
                            <button class="btn btn-primary  float-right" type="submit" value="submit">Submit</button>
                            <a href="{{ route('role_list') }}" class="btn btn-secondary"> Cancel</a>
                        </div>

                    </form>
            </div>
        </div>
    </div>
</x-aimadmin::layout.main>

