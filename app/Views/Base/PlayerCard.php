<div class="card shadow-sm mx-0 px-0 mb-3">
    <div class="player rounded-top-2">
        <source src="<?='/' . $recording->getVideoLink()?>">
    </div>
    <div class="card-body">
        <p class="card-text <?=($hideDescAndTitle)? "d-none" : ""?>"><?=$recording->getDescription()?></p>
        <div class="d-flex justify-content-between align-items-center">
            <small class="text-muted"><?=\App\Core\ConverterHelper::secondsToTime($recording->getLength())?></small>
        </div>
    </div>
</div>