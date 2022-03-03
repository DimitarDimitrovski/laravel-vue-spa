<div class="modal fade" id="deletePopup" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" data-url=""
     aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Delete Record</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <i class="fa fa-warning"></i>
                Are you sure that you want to delete this record?
            </div>
            <div class="modal-footer" style="justify-content: center">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">No</button>
                <button type="button" class="btn btn-success delete-item" data-bs-dismiss="modal">Yes</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="success" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Success!</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <i style="color: #0f5132; font-size: 50px" class="far fa-check-circle mb-3"></i>
                <h4 id="respMsg"></h4>
            </div>
            <div class="modal-footer" style="justify-content: center">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">OK</button>
            </div>
        </div>
    </div>
</div>
