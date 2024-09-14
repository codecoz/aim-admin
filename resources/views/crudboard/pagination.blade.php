<div class="clearfix d-flex justify-content-between align-items-center">
    <div class="flex-grow-1">
        <div class="text-start">
            {{ $data->links() }}
        </div>
    </div>
    <div class="flex-shrink-0">
        <div class="text-end">
            Showing {{ $data->firstItem() }} to {{ $data->lastItem() }} of {{ $data->total() }} entries
        </div>
    </div>
</div>
