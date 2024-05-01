<x-aimadmin::layout.login>
    <x-aimadmin::layout.auth-card>
        <x-slot name="logo">
            <img src="{{ asset('img/BL.png') }}" alt="Logo" style="width: 200px; height: auto;">
        </x-slot>
        <x-aimadmin::utils.error :messages="$errors->get('email')" class="mt-2"/>
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="input-group mb-3">
                <input type="text" name="email" class="form-control" value="{{old('email')}}"
                       placeholder="Email/Username">
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-envelope"></span>
                    </div>
                </div>
            </div>
            <div class="input-group mb-3">
                <input type="password" class="form-control" name="password" placeholder="Password">
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-lock"></span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-8">
                    <div class="icheck-primary">
                        <input type="checkbox" id="remember">
                        <label for="remember">
                            Remember Me
                        </label>
                    </div>
                </div>
                <!-- /.col -->
                <div class="col-4">
                    <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                </div>
                <!-- /.col -->
            </div>
        </form>
        <br>
        <hr>
        <form method="GET" action="{{ route('sso.login') }}">
            @csrf
            <div class="social-auth-links text-center mt-2 mb-3">
                <div class="d-grid mb-3">
                    <button class="btn btn-block btn-primary" type="submit">
                        <i class="fas fa-sign-in mr-2"></i> Sign in using SSO
                    </button>
                </div>
            </div>
        </form>

    </x-aimadmin::layout.auth-card>
</x-aimadmin::layout.login>
