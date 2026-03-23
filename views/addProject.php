<form action="index.php" method="POST" class="pt-4 pb-5">
    <input type="hidden" name="action" value="create">
    <div class="row g-3">
        <div class="col-sm-4">
            <input type="text" class="form-control" name="nameForm" placeholder="Project name">
        </div>

        <div class="col-sm-6">
            <input type="text" class="form-control" name="descriptionForm" placeholder="Description">
        </div>
        
        <div class="col-sm-2 d-flex justify-content-end">
            <button type="submit" class="btn btn-primary">Create Project</button>
        </div>
    </div>
</form>