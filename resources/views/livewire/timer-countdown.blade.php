<div>
    <span class="input-group-btn input-group-append ml-5">
        <button class="btn btn-success font-weight-bold" type="button" wire:text="minutes">00</button>
        <span class="p-2 font-weight-bold">:</span>
        <button class="btn btn-success font-weight-bold" type="button"wire:text="seconds">00</button>
        <button type="button" class="btn btn-danger dropdown-toggle ml-3" data-toggle="dropdown" aria-haspopup="true"
            aria-expanded="false">
            <i class="fa fa-clock"></i>
        </button>
    </span>
    <button wire:click="startTimer">Start</button>
    <button wire:click="pauseTimer">Pause</button>
</div>
