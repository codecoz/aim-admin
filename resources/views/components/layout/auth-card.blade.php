<div class="container d-flex flex-column">
    <div class="row vh-100">
        <div class="col-sm-12 col-md-10 col-lg-4 mx-auto d-table h-100">
            <div class="d-table-cell align-middle">
                <div class="card">
                    <div class="card-header text-center">
                        {{ $logo }}
                    </div>
                    <div class="card-body">
                        {{ $slot }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
