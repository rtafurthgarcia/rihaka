<div class="card shadow-sm mx-0">
    <div class="player">
        <?=$recording->getVideoLink()?>
    </div>
    <div class="card-body">
        <p class="card-text"><?=$recording->getDescription()?></p>
        <div class="d-flex justify-content-between align-items-center">
            <div class="btn-group">
                <button type="button" class="btn btn-sm btn-outline-secondary">View</button>
                <button type="button" class="btn btn-sm btn-outline-secondary">Edit</button>
            </div>
            <small class="text-muted"><?=$recording->getLength()?></small>
        </div>
    </div>
</div>