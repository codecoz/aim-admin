<x-aimadmin::layout.main>
    <x-slot:title>
        User Password Reset
    </x-slot:title>
    <div class="content">
        <div class="card mb-3">
            <div class="card-header">
                <h5 class="card-title mb-0">Change Password</h5>
            </div>
            <div class="card-body">
                <form name="user_form" action="{{ route('password.update') }}" method="post" class="needs-validation">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label" for="old_password">Old Password</label>
                        <input class="form-control" id="old_password" name="old_password" type="password" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="password">New Password</label>
                        <input class="form-control" id="password" name="password" type="password" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="password_confirmation">Confirm Password</label>
                        <input class="form-control" id="password_confirmation" name="password_confirmation"
                            type="password" required>
                        <div id="password-mismatch" class="text-danger"></div>
                    </div>
                    <button class="btn btn-primary" type="submit" id="submit-button" disabled>Submit</button>

                </form>
            </div>
        </div>
    </div>

    <script type="module">
        const passwordInput = document.getElementById('password');
        const confirmationInput = document.getElementById('password_confirmation');
        const mismatchMessage = document.getElementById('password-mismatch');
        const submitButton = document.getElementById('submit-button');

        confirmationInput.addEventListener('input', () => {
            const password = passwordInput.value;
            const confirmation = confirmationInput.value;

            if (password === confirmation) {
                mismatchMessage.innerText = '';
                submitButton.removeAttribute('disabled');
            } else {
                mismatchMessage.innerText = 'Passwords do not match.';
                submitButton.setAttribute('disabled', 'true');
            }
        });
    </script>
</x-aimadmin::layout.main>
