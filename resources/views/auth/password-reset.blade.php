<x-aim-admin::layout.login>
    <x-aim-admin::layout.auth-card>
        <x-slot name="logo">
            {{-- <img
            src="{{asset('img/cloudy4next.ico')}}"
            class="img-control"
            style="width: 120px; height: 120px"
            alt="cloudy4next"
          /> --}}
        </x-slot>
        <form method="POST" action="{{ route('password.reset.update') }}">

            @csrf
            <div class="input-group mb-3">
                <input class="form-control mt-1" type="email" name="email" placeholder="Enter email" required autofocus>
                <span class="input-group-text">
                    <i class="fa fa-envelope"> </i>
                </span>
            </div>
            {{-- <x-aim-admin::utils.error :messages="$errors->get('email')" class="mt-2" /> --}}
            <input type="hidden" id="token" name="token" value="{{ $token }}">

            <div class="input-group mb-3">
                <input class="form-control mt-1" type="password" name="password" placeholder="Enter password" required
                       autofocus>
                <span class="input-group-text">
                    <i class="fa fa-envelope"> </i>
                </span>
            </div>
            {{-- <x-aim-admin::utils.error :messages="$errors->get('password')" class="mt-2" /> --}}

            <div class="input-group mb-3">
                <input class="form-control  mt-1" id="password_confirmation" placeholder="Enter confirm password"
                       name="password_confirmation" type="password" required>

                <span class="input-group-text">
                    <i class="fa fa-envelope"> </i>
                </span>
                <x-aim-admin::utils.error :messages="$errors->get('password_confirmation')" class="mt-2"/>

            </div>
            <div class="d-grid mb-3">
                <button class="btn btn-primary w-100" type="submit" id="submit-button">Reset Password</button>
            </div>
        </form>
    </x-aim-admin::layout.auth-card>
</x-aim-admin::layout.login>
