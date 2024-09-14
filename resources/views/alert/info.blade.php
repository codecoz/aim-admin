<div class="alert alert-important alert-info alert-dismissible" role="alert">
    <div class="d-flex">
        <div>
            <!-- Download SVG icon from http://tabler-icons.io/i/info-circle -->
            <svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon" width="24" height="24" viewBox="0 0 24 24"
                 stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                <path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0"/>
                <path d="M12 9h.01"/>
                <path d="M11 12h1v4h1"/>
            </svg>
        </div>
        <div>
            {!! $message !!}
        </div>
    </div>
    <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
</div>
