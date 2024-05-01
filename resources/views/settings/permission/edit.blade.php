<x-aimadmin::layout.main>
    <div class="content">
        <div class="card mb-3">
            <div class="card-header ui-sortable-handle">
                <h3 class="card-title">
                    <i class="fa-solid fa-gear"></i>
                    Edit permission
                </h3>
                <div class="card-tools">
                    <ul class="nav nav-pills ml-auto">
                        <li class="nav-item">
                            <a href="{{route('permission_list')}}"
                               class="btn btn-primary end">
                                <i class="fas fa-arrow-left"></i>
                                Back
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="card-body">
                <form name="permission_form" action={{ route('permission_update') }} method="post">
                    @csrf
                    <input type="hidden" name="id" value="{{ $permission->id }}" />
                    <input type="hidden" name="applicationID" value="{{$permission->applicationID}}">

                    <div class="mb-3">
                        <label class="form-label" for="title">Title</label>
                        <input class="form-control  " id="title" name="title" type="text" placeholder="Title"
                               value="{{ $permission->title }}" />
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="shortDescription">Short Description</label>
                        <input class="form-control  " id="shortDescription" name="shortDescription" type="text"
                               value="{{ $permission->shortDescription }}" />
                    </div>

                    <div class="flex">
                        <button class="btn btn-primary  float-right" type="submit" value="submit">Submit</button>
                        <a href="{{ route('permission_list') }}" class="btn btn-secondary"> Cancel</a>
                    </div>

                </form>

            </div>
        </div>
    </div>
</x-aimadmin::layout.main>
