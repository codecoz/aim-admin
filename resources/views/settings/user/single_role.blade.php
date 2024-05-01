<x-aimadmin::layout.main>
    <x-slot:title>
        Single Role
    </x-slot:title>
    <div class="content">
        <div class="row">
            <div class="col-md-12 col-xl-12s">
                <div class="card mb-3">
                    <div class="card-header">
                        <h5 class="card-title mb-0">User Profile:</h5>
                        <div class="card-body">
                            <div class="row g-0 mt-1">
                                <div class="col-6">Title : {{ $data->title }}</div>
                                <div class="col-6">ShortDescription : {{ $data->shortDescription }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-aimadmin::layout.main>
