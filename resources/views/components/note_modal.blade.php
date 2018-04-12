<div class="modal inmodal" id="note-update-modal" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content animated">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Add Note</h4>
            </div>
            <div class="modal-body">
                <form id="update-note">
                    <input type="hidden" name="entity_id" value="{{ $entity->id }}" />
                    <input type="hidden" name="entity_type" value="{{ get_class($entity) }}" />
                    <div class="form-group" data-error="title">
                        <label>Title</label>
                        <input type="text" name="title" placeholder="Enter note title" required class="form-control">
                        <p class="text-danger text-left error-content"></p>
                    </div>
                    <div class="form-group" data-error="content">
                        <label>Content</label>
                        <textarea placeholder="Enter note content" name="content" required class="form-control" rows="5"></textarea>
                        <p class="text-danger text-left error-content"></p>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                <input type="submit" class="btn btn-primary" form="update-note" value="Save" />
            </div>
        </div>
    </div>
</div>