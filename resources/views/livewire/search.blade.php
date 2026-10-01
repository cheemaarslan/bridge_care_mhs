<div>
    <ul class="navbar-nav mr-auto float-left">
        <li class="nav-item search-box"> 
            <a class="nav-link d-none d-md-block waves-effect waves-dark" href="javascript:void(0)" wire:click="open_search_box"><i class="ti-search"></i>
            </a>
            <form wire:submit.prevent="search" class="app-search {{$show_search_box}}">
                <input type="text" class="form-control" wire:model="parameter" placeholder="Search Patient">
                <a class="srh-btn" wire:click="exit"><i class="ti-close"></i></a>
            </form>

        </li>
        <div class="dropdown-menu w-100 {{$dropdown}}">
            <ul class="mega-dropdown-menu row p-0 m-0 list-inline">
                <li class="col-12 mb-4">
                    <div class="row">
                        <div class="col-12">
                            <h4 class="m-3">Search Result..</h4>
                        </div>
                        @if ($patients)
                            @forelse ($patients as $item)
                                <div class="col-12">
                                    <div class="list-group">
                                        <a href="#"
                                            class="list-group-item list-group-item-action flex-column align-items-start">
                                            <div class="d-flex w-100 justify-content-between">
                                                <h5 class="mb-1">{{$item->first_name}} {{$item->last_name}}</h5>
                                                <small></small>
                                            </div>
                                            <p class="mb-1">{{$item->email}}</p>
                                            <small>{{$item->address}}</small>
                                        </a>
                                    </div>
                                </div>
                            @empty
                            <div class="col-12">
                                <div class="list-group">
                                    <a href="javascript:void(0)"
                                        class="list-group-item list-group-item-action flex-column align-items-start">
                                        <div class="d-flex w-100 justify-content-between">
                                            <h5 class="mb-1">No Patient Found</h5>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            @endforelse
                        @endif
                    </div>
                </li>
            </ul>
        </div>

    </ul>
</div>
