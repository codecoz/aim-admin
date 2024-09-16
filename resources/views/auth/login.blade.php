<x-aim-admin::layout.login>
    <x-aim-admin::layout.auth-card>
        <x-slot name="logo">
            <img src="{{ asset('img/logo.png') }}" alt="Logo" style="width: 150px; height: auto;">
        </x-slot>
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="input-group mb-3">
                <input type="email" name="email" class="form-control" value="{{old('email')}}"
                       placeholder="Email">
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-envelope"></span>
                    </div>
                </div>
                <x-aim-admin::utils.input-error :messages="$errors->get('email')" class="mt-2"/>
            </div>
            <div class="input-group mb-3">
                <input type="password" class="form-control" name="password" placeholder="Password">
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-lock"></span>
                    </div>
                </div>
                <x-aim-admin::utils.input-error :messages="$errors->get('password')" class="mt-2"/>
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

        <p class="mb-1">
            <a href="#">I forgot my password</a>
        </p>
        <p class="mb-0">
            <a href="{{route('registration')}}" class="text-center">Register a new membership</a>
        </p>

    </x-aim-admin::layout.auth-card>
</x-aim-admin::layout.login>
