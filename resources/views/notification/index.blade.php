@extends('master.app')
@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/libs/quill/dist/quill.snow.css') }}">
@endsection
@section('breadcrum')
<ol class="breadcrumb p-4">
    <li class="breadcrumb-item font-weight-bold">
        <a href="{{ route('home') }}" class="inactive">{{ env('APP_NAME') }} </a>
    </li>

    <?php $link = ' '; ?>
    @for ($i = 1; $i <= count(Request::segments()); $i++)
        @if (($i < count(Request::segments())) & ($i > 0))
            <?php $link .= ' /' . Request::segment($i); ?>
            @if ($i == 1)
                <li class="breadcrumb-item font-weight-bold">
                    <a href="<?= $link ?>" class="inactive">
                        {{ ucwords(str_replace('-', ' ', Request::segment($i))) }}</a>
                </li>
            @else
                <li class="breadcrumb-item font-weight-bold">
                    <a href="<?= $link ?>"
                        class="inactive">{{ ucwords(str_replace('-', ' ', Request::segment($i))) }}</a>
                </li>
            @endif
        @else
            <li class="breadcrumb-item font-weight-bold">
                <a class="active"> {{ ucwords(str_replace('-', ' ', Request::segment($i))) }}</a>
            </li>
        @endif
    @endfor
</ol>
@endsection
@section('content')
    <div class="email-app todo-box-container">
        <!-- ============================================================== -->
        <!-- Left Part -->
        <!-- ============================================================== -->
        <div class="left-part list-of-tasks">
            <a class="ti-menu ti-close btn btn-success show-left-part d-block d-md-none" href="javascript:void(0)"></a>
            <div class="scrollable" style="height:100%;">
                <div class="divider"></div>
                <ul class="list-group">
                    <li class="list-group-item p-0 border-0">
                        <a href="javascript:void(0)" class="todo-link active list-group-item-action p-3 d-block"
                            id="all-notification"><i class="mdi mdi-format-list-bulleted"></i> All Notification <span
                                class="todo-badge badge badge-info float-right"></span></a>
                    </li>
                    <li class="list-group-item p-0 border-0">
                        <a href="javascript:void(0)" class="todo-link list-group-item-action p-3 d-block"
                            id="unread"> <i class="mdi mdi-star"></i> Unread Notification <span
                                class="todo-badge badge badge-warning float-right"></span></a>
                    </li>
                    <li class="list-group-item p-0 border-0">
                        <a href="javascript:void(0)" class="todo-link list-group-item-action p-3 d-block"
                            id="read"> <i class="mdi mdi-send"></i> Read Notification <span
                                class="todo-badge badge badge-success float-right"></span></a>
                    </li>
                    <li class="list-group-item p-0 border-0">
                        <hr>
                    </li>
                    <li class="list-group-item p-0 border-0">
                        <a href="javascript:void(0)" class="list-group-item-action p-3 d-block" onclick="event.preventDefault();
                                    document.getElementById('mark_all_form').submit();"> <i
                                class="mdi mdi-delete"></i> Mark all as read </a>
                    </li>
                    <form action="{{route('notification.mark.all')}}" id="mark_all_form" method="post">
                        @csrf
                    </form>
                </ul>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- Right Part -->
        <!-- ============================================================== -->
        <div class="right-part mail-list bg-white overflow-auto">
            <div id="todo-list-container">
                <div class="p-3 border-bottom">
                    <div class="input-group searchbar">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="search"><i class="icon-magnifier text-muted"></i></span>
                        </div>
                        <input type="text" class="form-control w-100" placeholder="Search Here"
                            aria-describedby="search">
                    </div>
                </div>
                <!-- Todo list-->
                <div class="todo-listing">
                    <div id="all-notification-container" class="p-3">
                        @foreach ($notifications as $item)
                            <div class="todo-item all-notification p-3 border-bottom position-relative {{$item->read_at ? 'read' : 'unread'}}">
                                <div class="inner-item d-flex align-items-start">
                                    <div class="w-100">
                                        <!-- Checkbox -->
                                        <div class="checkbox checkbox-info d-flex align-items-start">
                                            <span class="btn {{$item->data['color']}} rounded-circle btn-circle"><i class="{{$item->data['icon']}}"></i></span>
                                            <div>
                                                <div class="content-todo ml-2">
                                                    <h5 class="font-medium font-16 todo-header mb-0">
                                                        <a href="{{$item->data['url']}}">{{ $item->data['title'] }}</a> </h5>
                                                    <div class="todo-subtext text-muted">
                                                        {{ $item->data['msg'] }}
                                                    </div>
                                                    <span class="todo-time font-12 text-muted">{{ \Carbon\Carbon::parse($item->creaated_at)->diffForHumans() }}</span>
                                                </div>
                                            </div>
                                            <div class="ml-auto">
                                                <div class="dropdown-action">
                                                    <div class="dropdown todo-action-dropdown">
                                                        <button
                                                            class="btn btn-link text-dark p-1 dropdown-toggle text-decoration-none todo-action-dropdown"
                                                            type="button" id="more-action-1" data-toggle="dropdown"
                                                            aria-haspopup="true" aria-expanded="false">
                                                            <i class="icon-options-vertical"></i>
                                                        </button>
                                                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="more-action-1">
                                                            <a class="important dropdown-item" href="javascript:void(0);" onclick="mark_as_read('{{$item->id}}')"><i
                                                                    class="ti-eye text-danger mr-1"></i> Mark as Read</a>
                                                            <a class="remove dropdown-item" href="javascript:void(0);" onclick="delete_notification('{{$item->id}}')"><i
                                                                    class="ti-trash text-danger mr-1"></i>Remove</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Content -->
                                    </div>
                                </div>
                            </div>
                        @endforeach

                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
@section('script')
    <script src="{{ asset('assets/libs/quill/dist/quill.min.js') }}"></script>
    <!-- Initialize Quill editor -->
    <script>
        $(function() {
            // Search Items
            $('.searchbar > input').on('keyup', function() {
                var rex = new RegExp($(this).val(), 'i');
                $('.todo-listing .todo-item').hide();
                $('.todo-listing .todo-item').filter(function() {
                    return rex.test($(this).text());
                }).show();
            });
        });

        // #####################################################
        // Notification Badge
        // #####################################################

        function dynamicNumberNotify(setTaskSectionCount) {
            var taskSectionCount = setTaskSectionCount;

            // Get Parents Div(s)
            var get_ParentsDiv = $('.todo-item');
            var get_AllNotificationParentsDiv = $('.todo-item.all-notification');
            var get_ReadNotificationParentsDiv = $('.todo-item.read');
            var get_UnreadNotificationParentsDiv = $('.todo-item.unread');

            // Get Parents Div(s) Counts
            var get_AllNotificationCount = get_AllNotificationParentsDiv.length;
            var get_ReadNotificationCount = get_ReadNotificationParentsDiv.length;
            var get_UnreadNotificationCount = get_UnreadNotificationParentsDiv.length;

            // Get Badge Div(s)
            var getBadgeAllNotificationDiv = $('#all-notification .todo-badge');
            var getBadgeReadNotificationDiv = $('#read .todo-badge');
            var getBadgeUneadNotificationDiv = $('#unread .todo-badge');


            if (taskSectionCount === 'all-notification') {
                if (get_AllNotificationCount === 0) {
                    getBadgeAllNotificationDiv.text('0');
                    return;
                }
                if (get_AllNotificationCount > 9) {
                    getBadgeAllNotificationDiv.css({
                        padding: '2px 0px',
                        height: '25px',
                        width: '25px'
                    });
                } else if (get_AllNotificationCount <= 9) {
                    getBadgeAllNotificationDiv.removeAttr('style');
                }
                getBadgeAllNotificationDiv.text(get_AllNotificationCount);
            } else if (taskSectionCount === 'read') {
                if (get_ReadNotificationCount === 0) {
                    getBadgeReadNotificationDiv.text('0');
                    return;
                }
                if (get_ReadNotificationCount > 9) {
                    getBadgeReadNotificationDiv.css({
                        padding: '2px 0px',
                        height: '25px',
                        width: '25px'
                    });
                } else if (get_ReadNotificationCount <= 9) {
                    getBadgeReadNotificationDiv.removeAttr('style');
                }
                getBadgeReadNotificationDiv.text(get_ReadNotificationCount);
            } else if (taskSectionCount === 'unread') {
                if (get_UnreadNotificationCount === 0) {
                    getBadgeUneadNotificationDiv.text('0');
                    return;
                }
                if (get_UnreadNotificationCount > 9) {
                    getBadgeUneadNotificationDiv.css({
                        padding: '2px 0px',
                        height: '25px',
                        width: '25px'
                    });
                } else if (get_UnreadNotificationCount <= 9) {
                    getBadgeUneadNotificationDiv.removeAttr('style');
                }
                getBadgeUneadNotificationDiv.text(get_UnreadNotificationCount);
            }

        }

        new dynamicNumberNotify('all-notification');
        new dynamicNumberNotify('read');
        new dynamicNumberNotify('unread');


        var $btns = $('.list-group-item-action').click(function() {
            if (this.id == 'all-notification') {
                    var $el = $('.' + this.id).fadeIn();
                    $('#all-notification-container > div').not($el).hide();
            } else if (this.id == 'read') {
                    var $el = $('.' + this.id).fadeIn();
                    $('#all-notification-container > div').not($el).hide();
            } else {
                    var $el = $('.' + this.id).fadeIn();
                    $('#all-notification-container > div').not($el).hide();
            }
            $btns.removeClass('active');
            $(this).addClass('active');
        })

    </script>
@endsection
