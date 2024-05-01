<x-aimadmin::layout.main>
    <div class="content">
        <div class="card mb-3">
            <div class="card-header ui-sortable-handle">
                <h3 class="card-title">
                    <i class="fa-solid fa-gear"></i>
                    Edit User Group
                </h3>
                <div class="card-tools">
                    <ul class="nav nav-pills ml-auto">
                        <li class="nav-item">
                            <a href="{{route('user_group_list')}}"
                               class="btn btn-primary end">
                                <i class="fas fa-arrow-left"></i>
                                Back
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="card-body">
                <form name="user_group_form" action={{ route('user_group_update') }} method="post">
                    @csrf
                    <input type="hidden" name="id" value="{{ $requestedGroup->id }}"/>
                    <input type="hidden" name="applicationID" value="{{$requestedGroup->applicationID}}">

                    <div class="mb-3">
                        <label class="form-label" for="title">Slug</label>
                        <input class="form-control  " id="name" name="name" type="text" placeholder="name"
                               value="{{ $requestedGroup->name }}"/>
                    </div>

                    <div class="flex">
                        <button class="btn btn-primary  float-right" type="submit" value="submit">Submit</button>
                        <a href="{{ route('user_group_list') }}" class="btn btn-secondary"> Cancel</a>
                    </div>

                </form>

            </div>
        </div>
    </div>
</x-aimadmin::layout.main>

