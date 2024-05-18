<div id="cc-modal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title"></h4>
            </div>
            <!-- //Message from Ajax request// -->
            <div class="card-body box-modal-message" style="display: none;">
                <div class="alert alert-success alert-dismissible" style="display: none;">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <span></span>
                </div>
                <div class="alert alert-warning alert-dismissible" style="display: none;">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <span></span>
                </div>
            </div>
            <div class="modal-body" id="modal-body-content">
                Loading <img src="{{asset('img/loader.gif')}}" title="loading">
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div> <!-- /.modal -->

