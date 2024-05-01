@php use Illuminate\Support\Facades\Auth; @endphp
<x-aimadmin::layout.main>
    <div class="content">
        <div class="card card-widget widget-user">
            <div class="widget-user-header bg-warning">
                <h3 class="widget-user-username mb-1 text-white">{{ $data->fullName }}</h3>
                <h5 class="widget-user-desc text-white">{{$data?->roles[0]?->title??'Role is not assigned'}}</h5>
            </div>
            <div class="widget-user-image">
                <img class="img-circle elevation-2" src="{{Auth::user()->userImage()??asset('img/blx100x100.png')}}"
                     alt="User Avatar">
            </div>
            <div class="card-footer">
                <div class="row">
                    <div class="col-sm-4 border-right">
                        <div class="description-block">
                            <h5 class="description-header">User Name</h5>
                            <span class="">{{ $data->userName }}</span>
                        </div>

                    </div>

                    <div class="col-sm-4 border-right">
                        <div class="description-block">
                            <h5 class="description-header">Mobile</h5>
                            <span class="">{{ $data->mobileNumber }}</span>
                        </div>

                    </div>

                    <div class="col-sm-4">
                        <div class="description-block">
                            <h5 class="description-header">Email</h5>
                            <span class="">{{ $data->emailAddress }}</span>
                        </div>

                    </div>

                </div>

            </div>
        </div>
    </div>
</x-aimadmin::layout.main>
