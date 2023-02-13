<?php
    use App\Models\Worker;
?>

<div class="container mt-4">

    <div class="row">
        <h1 class="display-4">Workers</h1>
    </div>

    <div class="row justify-content-center text-end">
        <div class="col-md-10">
            <button class="btn btn-primary" id="btn_create_worker">
                Create new
            </button>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-10">
            <table class="table table-striped" id="tbl_workers">
                <thead>
                <tr>
                    <form method="GET" action="/workers" id="frm_sort">
                        <td><button class="btn btn-outline-secondary" type="submit" name="field" value="first_name">First name</button></td>
                        <td><button class="btn btn-outline-secondary" type="submit" name="field" value="last_name">Last name</button></td>
                        <td><button class="btn btn-outline-secondary" type="submit" name="field" value="phone">Phone</button></td>
                        <td>Status</td>
                        <td><button class="btn btn-outline-secondary" type="submit" name="field" value="salary">Salary</button></td>
                        <td>Actions</td>
                        <input type="hidden" name="frm_sort_workers">
                    </form>
                </tr>
                </thead>
                <tbody id="tbl_body_workers">
                    <?php foreach ($workers as $worker): ?>
                        <tr data-worker-id="<?= $worker->id ?>">
                            <td><?= $worker->first_name ?></td>
                            <td><?= $worker->last_name ?></td>
                            <td><?= $worker->phone ?></td>
                            <td>
                                <?php if ($worker->status === Worker::WORKER_STATUS_ACTIVE): ?>
                                    <img src="img/green_led.png" alt="active worker" width="20">
                                <?php else: ?>
                                    <img src="img/red_led.png" alt="inactive worker" width="20">
                                <?php endif; ?>
                            </td>
                            <td><?= $worker->salary ?></td>
                            <td>
                                <button class="btn btn-warning btn-sm" data-action="edit">
                                    <i class="bi bi-pencil-fill"></i>
                                </button>
                                <button class="btn btn-danger btn-sm" data-action="delete">
                                    <i class="bi bi-trash-fill"></i>
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="modal" id="mdl_create_worker">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Create a new worker</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="first_name" class="form-label">First name</label>
                        <input name="first_name" type="text" class="form-control" id="first_name">
                    </div>
                    <div class="mb-3">
                        <label for="last_name" class="form-label">Last name</label>
                        <input name="last_name" type="text" class="form-control" id="last_name">
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone</label>
                        <input name="phone" type="text" class="form-control" id="phone">
                    </div>
                    <div class="mb-3">
                        <label for="salary" class="form-label">Salary</label>
                        <input name="salary" type="number" class="form-control" id="salary">
                    </div>
                    <div class="mb-3">
                        <label for="status" class="form-check-label">Active</label>
                        <input name="status" type="checkbox" class="form-check-input" id="status">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="btn_save_worker">Save</button>
                </div>
            </div>
        </div>
    </div>

    <div class="toast-container position-fixed bottom-0 end-0 p-3">
        <div id="live_toast" class="toast align-items-center text-bg-success" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    Worker created successfully
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>

</div>

<script src="js/index.js" type="module"></script>
