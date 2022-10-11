<div class="card shadow-sm mx-0 px-0 mb-3">
    <div class="player">
        <source src="<?='/' . $recording->getVideoLink()?>">
    </div>
    <div class="card-body">
        <p class="card-text"><?=$recording->getDescription()?></p>
        <div class="d-flex justify-content-between align-items-center">
            <div class="btn-group">
                <button type="button" class="btn btn-sm btn-outline-secondary">View</button>
                <? if (! $hideEdit): ?>
                    <button type="button" class="btn btn-sm btn-outline-secondary">Edit</button>
                <? endif; ?>
            </div>
            <small class="text-muted"><?=$recording->getLength()?></small>
        </div>
    </div>
</div>