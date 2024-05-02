@php
    $name = Illuminate\Support\Facades\Auth::user()->name;
    $memberSince = Illuminate\Support\Facades\Auth::user()->created_at;
    $image = Illuminate\Support\Facades\Auth::user()->userImage();
@endphp
<li class="nav-item dropdown user-menu">
    <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
        <img src="{{asset('dist/img/avatar5.png')}}"
             class="user-image img-circle elevation-2" alt="User Image">
        <span class="d-none d-md-inline">{{$name}}</span>
    </a>
    <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
        <!-- User image -->
        <li class="user-header bg-blue">
            <img src="{{asset('dist/img/avatar5.png')}}" class="img-circle"
                 alt="User Image">
            <p class="text-white">
                {{$name}}
            </p>
        </li>
        <!-- Menu Footer-->
        <li class="user-footer">
            <a href="{{ config('aim-admin.auth.profile_url') }}" class="btn btn-default btn-flat">Profile</a>
            <a href="{{ route('logout') }}" class="btn btn-default btn-flat float-right">Sign out</a>
        </li>
    </ul>
</li>
