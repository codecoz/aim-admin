<x-aimadmin::layout.main>
    <div class="content">
        <div class="card mb-3">
            <div class="card-header ui-sortable-handle">
                <h3 class="card-title">
                    <i class="fa-solid fa-gear"></i>
                    Edit role
                </h3>
                <div class="card-tools">
                    <ul class="nav nav-pills ml-auto">
                        <li class="nav-item">
                            <a href="{{route('role_list')}}"
                               class="btn btn-sm btn-primary end">
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
                    <div class="mb-3">
                        <label class="form-label" for="title">Title</label>
                        <input class="form-control  " id="title" name="title" type="text" placeholder="Title"
                               value="{{ $role->title }}"/>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="shortDescription">Short Description</label>
                        <input class="form-control  " id="shortDescription" name="shortDescription" type="text"
                               value="{{ $role->shortDescription }}"/>
                    </div>

                    <hr class="mb-2">

                    <button class="btn btn-primary " type="submit">Submit</button>
                    <a href="{{ route('role_list') }}" class="btn btn-secondary"> Cancel </a>
                </form>
            </div>
        </div>
    </div>
</x-aimadmin::layout.main>

