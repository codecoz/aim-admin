<x-aimadmin::layout.login>
    <x-aimadmin::layout.auth-card>
        <x-slot name="logo">
            <img src="{{ asset('img/BL.png') }}" alt="Logo" style="width: 200px; height: auto;">
        </x-slot>
        <div class="text-center">
            <h2 class="mb-3">OTP Verification</h2>
        </div>

        <form method="POST" action="{{ route('otp.verify') }}">
            @csrf

            <div class="mb-3">
                <input id="otp" class="form-control" type="number" name="otp" :value="old('otp')"
                    placeholder="Enter OTP" required>
            </div>

            @foreach ($fields as $type => $key)
                <div class="mb-3">
                    <label for="{{ $key }}"
                        class="form-label">{{ ucwords(str_replace('_', ' ', $key)) }}</label>
                    <input id="{{ $key }}" class="form-control" type="{{ $type }}"
                        name="{{ $key }}" :value="old('{{ $key }}')"
                        placeholder="Enter {{ ucwords(str_replace('_', ' ', $key)) }}" required>
                </div>
            @endforeach


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
                <button class="btn btn-primary w-100" type="submit">Submit</button>
            </div>

        </form>

    </x-aimadmin::layout.auth-card>
</x-aimadmin::layout.login>
