<footer class="footer d-none" id="footer">
    <span class="input-group-btn input-group-append ml-5">
        <button class="btn btn-success font-weight-bold" type="button" id="minutes">00</button>
        <span class="p-2 font-weight-bold">:</span>
        <button class="btn btn-success font-weight-bold" type="button" id="seconds">00</button>
        <button type="button" class="btn btn-danger dropdown-toggle ml-3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fa fa-clock"></i>
        </button>
        <div class="dropdown-menu" id="timer_option">
            <button class="dropdown-item" type="button" id="start_timer_btn">Start</button>
            <button class="dropdown-item d-none" type="button" id="pause_timer_btn">Pause</button>
            <button class="dropdown-item" type="button" id="save_with_automated_note_btn">Save With Automated Note</button>
            <button class="dropdown-item" type="button" id="save_with_custom_note_btn">Save With Custom Note</button>
            <div class="dropdown-divider"></div>
            <button type="button" class="dropdown-item" id="reset_timer_btn">Reset</button>
        </div>
    </span>
</footer>