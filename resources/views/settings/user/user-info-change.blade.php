<x-aimadmin::layout.main>
    <x-slot:title>
        User Info Change
    </x-slot:title>
    <div class="content">
        <div class="card mb-3">
            <div class="card-header">
                <h5 class="card-title mb-0">User Info Change</h5>
            </div>
            <div class="card-body">
                <form name="user_form" action="{{ route('user_info.update', Auth::id()) }}" method="post"
                      class="needs-validation" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label" for="fullName">Full Name</label>
                        <input class="form-control" id="fullName" name="fullName" value="{{ $user->fullName }}"
                               type="text">
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="image">Photo</label>
                        <input class="form-control" id="image" name="image" type="file">
                    </div>

                    <input type="hidden" name="old_image" value="{{ $user->profilePicID }}">
                    <input type="hidden" name="isActiveUser" value="1">
                    <input type="hidden" name="id" value="{{ Auth::id() }}">
                    <input type="hidden" name="userName" value="{{ $user->userName }}">
                    <input type="hidden" name="password" value="{{ $user->password }}">
                    <input type="hidden" name="emailAddress" value="{{ $user->emailAddress }}">
                    <input type="hidden" name="mobileNumber" value="{{ $user->mobileNumber }}">

                    <button class="btn btn-primary" type="submit" id="submit-button">Submit</button>

                </form>
            </div>
        </div>
    </div>
</x-aimadmin::layout.main>
