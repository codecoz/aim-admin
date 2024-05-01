<x-aimadmin::layout.login>
    <x-aimadmin::layout.auth-card>
        <x-slot name="logo">
            <img src="{{ asset('img/BL.png') }}" alt="Logo" style="width: 200px; height: auto;">
        </x-slot>
        <div class="text-center">
            <h2 class="mb-3">User Registration</h2>
        </div>

        <form method="POST" action="{{ route('registration') }}">
            @csrf

            <div class="mb-3">
                <label for="full_name" class="form-label">Full Name</label>
                <input id="full_name" class="form-control" type="text" name="full_name" :value="old('full_name')"
                    placeholder="Enter Full Name" required>
            </div>

            <div class="mb-3">
                <label for="dob" class="form-label">Date of Birth</label>
                <input id="dob" class="form-control" type="date" name="dob" :value="old('dob')"
                    required>
            </div>


            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <div class="input-group">
                    <input id="password" class="form-control" type="password" name="password"
                        placeholder="Enter Password" required autocomplete="current-password">
                    <div class="input-group-append">
                        <span class="input-group-text">
                            <i class="fa fa-lock"></i>
                        </span>
                    </div>
                </div>
            </div>
            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Confirm Password</label>
                <div class="input-group">
                    <input id="password_confirmation" type="password" class="form-control" name="password_confirmation"
                        required>
                    <div class="input-group-append">
                        <span class="input-group-text">
                            <i class="fa fa-lock"></i>
                        </span>
                    </div>
                </div>
            </div>

            <div class="d-grid mb-3">
                <button class="btn btn-primary w-100" type="submit">Register</button>
            </div>

        </form>

    </x-aimadmin::layout.auth-card>
</x-aimadmin::layout.login>
