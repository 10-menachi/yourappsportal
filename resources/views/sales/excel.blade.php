<div id="salesModal" class="modal fade" tabindex="-1" aria-labelledby="salesModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="salesModalLabel">Sales Excel Upload</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('sales.file.upload') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input required="required" type="file" name="file" class="form-control mb-3">
                    <button class="btn btn-primary w-100" type="submit">Upload File</button>
                </form>
            </div>
        </div>
    </div>
</div>
