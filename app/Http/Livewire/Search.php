<?php

namespace App\Http\Livewire;

use App\Models\Patient;
use Livewire\Component;

class Search extends Component
{
    public $parameter;
    public $patients;
    public $dropdown = "";
    public $show_search_box = "";
    public function render()
    {
        return view('livewire.search');
    }
    public function open_search_box()
    {
        $this->show_search_box = "d-block";
    }
    public function search()
    {
        $this->dropdown = "show";
        $this->patients = Patient::where('first_name', 'like',"%{$this->parameter}%")
        ->orWhere('last_name', 'like',"%{$this->parameter}%")->limit(5)->get();
    }
    public function exit()
    {
        $this->reset();
    }
}
