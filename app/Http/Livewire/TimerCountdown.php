<?php

namespace App\Http\Livewire;

use Livewire\Component;

class TimerCountdown extends Component
{
    public $minutes;
    public $seconds;

    public function mount()
    {
        $this->minutes = 0;
        $this->seconds = 0;
    }

    public function render()
    {
        return view('livewire.timer-countdown');
    }
    public function startTimer()
    {
        $this->dispatchBrowserEvent('start-timer');
    }
    public function updateTime()
    {
        dd('a');
        if ($this->seconds === 59) {
            $this->seconds = 0;
            $this->minutes++;
        } else {
            $this->seconds++;
        }
    }
    public function pauseTimer()
    {
        $this->dispatchBrowserEvent('pause');
    }
}
