<div class="container d-flex flex-column">
    @if(env('LOGIN_NOTICE'))
        <div class="row">
            <div class="col-12 mt-5 d-table">
                <div class="col-lg-6 col-md-6 col-sm-12 offset-lg-3 offset-md-3">
                    <div class="callout callout-danger">
                        @php
                            $loginNotice = env('LOGIN_NOTICE');
                            if (str_contains($loginNotice, ':::')) {
                                $noticeParts = explode(':::', $loginNotice);
                                $noticeTitle = $noticeParts[0];
                                $noticeMessage = $noticeParts[1];
                            } else {
                                $noticeTitle = null;
                                $noticeMessage = $loginNotice;
                            }
                        @endphp
                        <h5>
                            @if($noticeTitle)
                                {!! $noticeTitle !!}
                            @else
                                Notice!
                            @endif
                        </h5>
                        <p>{!! $noticeMessage !!}</p>
                    </div>

                </div>
            </div>
            @else
                <div class="row vh-100">
                    @endif
                    <div class="col-sm-12 col-md-10 col-lg-4 mx-auto d-table h-100">
                        <div class="d-table-cell align-middle">
                            <div class="card">
                                <div class="card-header text-center">
                                    {{ $logo }}
                                </div>
                                <div class="card-body">
                                    @if(config('aim-admin.show_inline_alert_box', true))
                                        <x-aim-admin::utils.error :messages="$errors->all()" class="mt-2"/>
                                    @endif
                                    {{ $slot }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
