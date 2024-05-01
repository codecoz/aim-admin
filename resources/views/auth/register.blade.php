<x-aimadmin::layout.login>
    <x-aimadmin::layout.auth-card>
        <x-slot name="logo">
            <img src="{{ asset('img/BL.png') }}" alt="Logo" style="width: 200px; height: auto;">
        </x-slot>
        <div class="text-center">
            <h3 class="mb-3">User Registration - Step 1</h3>
        </div>

        <form method="POST" action="{{ route('send.otp') }}">
            @csrf
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <div class="input-group">
                    <input id="email" class="form-control" type="email" name="email" :value="old('email')"
                        placeholder="Enter Email" required autofocus>
                    <div class="input-group-append">
                        <span class="input-group-text">
                            <i class="fa fa-envelope"></i>
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
