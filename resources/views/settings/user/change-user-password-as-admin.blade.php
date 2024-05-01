<x-aimadmin::layout.main>
    <x-slot:title>
        Change Password
    </x-slot:title>
    <div class="content">
        <div class="card mb-3">
            <div class="card-header">
                <h5 class="card-title mb-0">User Password Reset:</h5>
            </div>
            <div class="card-body">
                <form name="user_form" action="{{ route('password.update') }}" method="post" class="needs-validation">
                    @csrf

                    <input type="hidden" name="id" value="{{ $id }}" />

                    <div class="mb-3">
                        <label class="form-label" for="user_id">ID</label>
                        <input class="form-control" id="old_password" name="user_id" value="{{ $id }}"
                            type="text" disabled>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="password">New Password</label>
                        <input class="form-control" id="password" name="password" type="password" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="password">Confirm Password</label>
                        <input class="form-control" id="password" name="password_confirmation" type="password" required>
                    </div>
                    <button class="btn btn-primary" type="submit" id="submit-button">Submit</button>
                </form>
            </div>
        </div>
    </div>
</x-aimadmin::layout.main>
