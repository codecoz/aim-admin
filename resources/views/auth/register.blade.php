<x-aimadmin::layout.login>
    <x-aimadmin::layout.auth-card>
        <x-slot name="logo">
            <img src="{{ asset('logo.png') }}" alt="Logo" style="width: 150px; height: auto;">
        </x-slot>
        <div class="text-center">
            <h3 class="mb-3">User Registration</h3>
        </div>
        <x-aimadmin::utils.error :messages="$errors" class="mt-2"/>
        <form method="POST" action="{{ route('registration') }}">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <div class="input-group">
                    <input id="name" class="form-control" type="text" name="name" :value="old('name')"
                           placeholder="Enter Name" required autofocus>
                    <div class="input-group-append">
                        <span class="input-group-text">
                            <i class="fa fa-envelope"></i>
                        </span>
                    </div>
                </div>
            </div>

            <div class="input-group mb-3">
                <input type="text" name="email" class="form-control" value="{{old('email')}}"
                       placeholder="Email">
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

            <div class="input-group mb-3">
                <input type="password" class="form-control" name="password_confirmation" placeholder="Confirm Password">
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-lock"></span>
                    </div>
                </div>
            </div>
            <div class="d-grid mb-3">
                <button class="btn btn-primary w-100" type="submit">Register</button>
            </div>
            <a href="{{route('login')}}" class="text-center">I already have a membership</a>
        </form>

    </x-aimadmin::layout.auth-card>
</x-aimadmin::layout.login>
