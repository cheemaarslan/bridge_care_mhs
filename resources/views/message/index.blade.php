@extends('master.app')
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
    <div class="preloader">
        <div class="lds-ripple">
            <div class="lds-pos"></div>
            <div class="lds-pos"></div>
        </div>
    </div>
    <div class="chat-application">
        <!-- ============================================================== -->
        <!-- Left Part  -->
        <!-- ============================================================== -->
        <div class="left-part bg-white fixed-left-part user-chat-box">
            <!-- Mobile toggle button -->
            <a class="ti-menu ti-close btn btn-success show-left-part d-block d-md-none" href="javascript:void(0)"></a>
            <!-- Mobile toggle button -->
            <div class="p-3">
                <h4>Chat Sidebar</h4>
            </div>
            <div class="scrollable position-relative" style="height:100%;">

                <div class="p-3 border-bottom">
                    <h5 class="card-title">Search Contact</h5>
                    <div class="searchbar">
                        <input class="form-control" type="text" placeholder="Search Contact">
                    </div>
                </div>

                <ul class="mailbox list-style-none app-chat">
                    <li>
                        <div class="message-center chat-scroll chat-users">
                            @foreach ($patients as $item)
                                <a href="javascript:void(0)"
                                    class="chat-user message-item align-items-center border-bottom px-3 py-2"
                                    data-user-id='{{ $item->id }}'>
                                    <span class="user-img position-relative d-inline-block">
                                        <img src="{{ $item->patient_image }}"
                                            alt="{{ $item->first_name }} {{ $item->last_name }}"
                                            class="rounded-circle w-100">
                                        <span class="profile-status online rounded-circle pull-right"></span>
                                    </span>
                                    <div class="mail-contnet w-75 d-inline-block v-middle pl-2">
                                        <h5 class="message-title mb-0 mt-1"
                                            data-username="{{ $item->first_name }} {{ $item->last_name }}">
                                            {{ $item->first_name }} {{ $item->last_name }}</h5>
                                        <span
                                            class="font-12 text-nowrap d-block text-muted text-truncate">{{ $item->contact_no }}</span>
                                    </div>
                                    @if ($item->messages_count > 0)
                                        <span class="badge py-1 badge-danger float-right">{{ $item->messages_count }}</span>
                                    @endif

                                </a>
                            @endforeach
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- End Left Part  -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Right Part  Mail Compose -->
        <!-- ============================================================== -->
        <div class="right-part chat-container">
            <div class="chat-box-inner-part">
                <div class="chat-not-selected">
                    <div class="text-center">
                        <span class="display-5 text-success"><i class="mdi mdi-comment-outline"></i></span>
                        <h5>Open chat from the list</h5>
                    </div>
                </div>
                <div class="card chatting-box mb-0">
                    <div class="card-body">
                        <div class="chat-meta-user pb-3 border-bottom">
                            <div class="current-chat-user-name">
                                <span class="mr-5">
                                    <img src="{{ asset('assets/images/users/1.jpg') }}" alt="dynamic-image"
                                        class="rounded-circle" width="45">
                                    <span class="name font-weight-bold ml-2"></span>

                                </span>

                                <div class="float-right mr-4">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-outline-secondary text-white mr-1"
                                            id="refresh_conversation_btn">
                                            <i class="mdi mdi-reload" id="conversation_icon"></i>
                                            <span class="spinner-border spinner-border-sm d-none" id="conversation_spinner"
                                                role="status" aria-hidden="true"></span>
                                            <span class="sr-only">Loading...</span>
                                        </button>
                                        @can('delete_message')
                                            <button type="button" class="btn btn-outline-secondary text-white"
                                                id="delete_conversation_btn"><i class="mdi mdi-delete"></i></button>
                                        @endcan
                                    </div>
                                </div>
                            </div>

                        </div>
                        <!-- <h4 class="card-title">Chat Messages</h4> -->
                        <div class="chat-box scrollable" style="height:calc(100vh - 300px);">
                            <!--User 1 -->
                            <ul class="chat-list chat" id="chat-list">
                            </ul>
                        </div>
                    </div>
                    <div class="card-body border-top border-bottom chat-send-message-footer">
                        <div class="row">
                            <div class="col-12">
                                <div class="input-field mt-0 mb-0">
                                    <input id="textarea1" placeholder="Type and hit enter"
                                        style="font-family:Arial, FontAwesome"
                                        class="message-type-box form-control border-0 " type="text">
                                    <a href="javascript:void(0)" onclick="myFunction()" class="send_btn"> <i
                                            class="fa fa-paper-plane" aria-hidden="true"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ asset('dist/js/app.min.js') }}"></script>
    <script src="{{ asset('dist/js/app.init.js') }}"></script>
    <script src="{{ asset('dist/js/sidebarmenu.js') }}"></script>
    <script>
        var patient_id = null;
        setInterval(function() {
            $.ajax({
                url: "{{ route('un_read_message') }}",
                type: "get",
                success: function(response) {
                    if (response.length > 0) {
                        $.each(response, function(index, value) {
                            var parent = $('.chat-user[data-user-id = ' + value.id + ']');
                            var count = parseInt(value.messages_count);
                            if ($(parent).find('span.badge-danger').length) {
                                if (count > 0) {
                                    $(parent).find('span.badge-danger').html(count);
                                }
                            } else {
                                if (count > 0) {
                                    $(parent).append(
                                        '<span class="badge py-1 badge-danger float-right">' +
                                        count + '</span>');
                                }
                            }
                        });
                    }
                },
                error: function() {
                    console.log('something went wrong');
                }
            });
        }, 40000);

        $('#add_patient_btn').click(function() {
            $('#patient_modal').modal('show');
        });

        function append_message(response) {
            if (response.length > 0) {
                $('#chat-list').children("li").remove();
                $('#chat-list').addClass('active-chat');
                $.each(response, function(index, value) {
                    var type = "odd";
                    var textColor = "text-dark";
                    var textBg = "bg-light-inverse";
                    var direction = "text-right";
                    if (value.type == "Incoming") {
                        type = "even";
                        textColor = "text-white";
                        textBg = "bg-success";
                        direction = "";
                    }
                    var messageHtml = '<li class="' + type + ' mt-4">' +
                        '<div class="chat-content pl-3 d-inline-block ' + direction + '">' +
                        '<div class="box mb-2 d-inline-block ' + textColor + ' rounded p-2 ' + textBg + '">' +
                        value.body +
                        '</div>' +
                        '<p class="text-muted">' + value.formatted_date + '</p>' +
                        '</div> ' +
                        '</li>';
                    var appendMessage = $('#chat-list').append(messageHtml);
                });

            } else {
                $('#chat-list').children("li").remove();
                $('#chat-list').addClass('active-chat');

                var messageHtml = '<li class="mt-4">' +
                    '<div class="chat-content pl-3 d-inline-block text-center">' +
                    '<div class="box mb-2 d-inline-block text-dark rounded p-2 bg-light-primary">No Chat Found</div>' +
                    '</div> ' +
                    '</li>';
                var appendMessage = $('#chat-list').append(messageHtml);
            }
            // var ms_alert = '<span class="badge py-1 badge-danger float-right">5</span>'
        }

        // *******************************************************************
        // Chat Application
        // *******************************************************************
        $('.searchbar > input').on('keyup', function() {
            var rex = new RegExp($(this).val(), 'i');
            $('.chat-users .chat-user').hide();
            $('.chat-users .chat-user').filter(function() {
                return rex.test($(this).text());
            }).show();
        });
        $('.app-chat .chat-user ').on('click', function(event) {
            if ($(this).hasClass('.active')) {
                return false;
            } else {
                var findChat = $(this).attr('data-user-id');
                if ($(this).find('span.badge-danger').length) {
                    $(this).find('span.badge-danger').remove();
                }
                patient_id = findChat;
                var personName = $(this).find('.message-title').text();
                var personImage = $(this).find('img').attr('src');
                var hideTheNonSelectedContent = $(this).parents('.chat-application').find('.chat-not-selected')
                    .hide().siblings('.chatting-box').show();
                var showChatInnerContent = $(this).parents('.chat-application').find(
                    '.chat-container .chat-box-inner-part').show();

                if (window.innerWidth <= 767) {
                    $('.chat-container .current-chat-user-name .name').html(personName.split(' ')[0]);
                } else if (window.innerWidth > 767) {
                    $('.chat-container .current-chat-user-name .name').html(personName);
                }
                $('.chat-container .current-chat-user-name img').attr('src', personImage);
                $('.chat').removeClass('active-chat');
                $('.user-chat-box .chat-user').removeClass('active');
                //$('.chat-container .chat-box-inner-part').css('height', '100%');
                $(this).addClass('active');
                $('.chat[data-user-id = ' + findChat + ']').addClass('active-chat');

            }
            if ($(this).parents('.user-chat-box').hasClass('user-list-box-show')) {
                $(this).parents('.user-chat-box').removeClass('user-list-box-show');
            }
            $('.chat-meta-user').addClass('chat-active');
            //$('.chat-container').css('height', 'calc(100vh - 158px)');
            $('.chat-send-message-footer').addClass('chat-active');
            show_conversation();

        });

        // Send Messages
        $('.message-type-box').on('keydown', function(event) {
            if (event.key === 'Enter') {
                // Start getting time
                var now = new Date();
                var hh = now.getHours();
                var min = now.getMinutes();

                var ampm = (hh >= 12) ? 'pm' : 'am';
                hh = hh % 12;
                hh = hh ? hh : 12;
                hh = hh < 10 ? '0' + hh : hh;
                min = min < 10 ? '0' + min : min;

                var time = hh + " : " + min + " " + ampm;
                // End

                var chatInput = $(this);
                var chatMessageValue = chatInput.val();
                if (chatMessageValue === '') {
                    return;
                }

                $.ajax({
                    url: "{{ route('message.store') }}",
                    type: "post",
                    data: {
                        msg: chatMessageValue,
                        type: "msg",
                        patient_id: patient_id
                    },
                    beforeSend: function() {
                        $('#conversation_icon').addClass('d-none');
                        $('#conversation_spinner').removeClass('d-none');
                    },
                    success: function(response) {
                        var messageHtml = '<li class="odd mt-4">' +
                            '<div class="chat-content pl-3 d-inline-block text-right">' +
                            '<div class="box mb-2 d-inline-block text-dark rounded p-2 bg-light-inverse">' +
                            chatMessageValue +
                            '</div>' +
                            '<p class="text-muted">Just Now</p>' +
                            '</div> ' +
                            '</li>';
                        var appendMessage = $('#chat-list').append(messageHtml);
                        var clearChatInput = chatInput.val('');
                        $('#conversation_spinner').addClass('d-none');
                        $('#conversation_icon').removeClass('d-none');
                    },
                    error: function(response) {
                        $('#conversation_spinner').addClass('d-none');
                        $('#conversation_icon').removeClass('d-none');
                        toastr.error(response.responseJSON.message, 'Error!', {
                            "showMethod": "slideDown",
                            "hideMethod": "slideUp",
                            timeOut: 4000
                        });
                    }
                });

            }
        });

        $('#refresh_conversation_btn').click(function() {
            show_conversation();
        });

        function show_conversation() {
            if (patient_id) {

                $.ajax({
                    url: "{{ route('conversation.index') }}",
                    type: "post",
                    data: {
                        patient_id: patient_id
                    },
                    beforeSend: function() {
                        $('#conversation_icon').addClass('d-none');
                        $('#conversation_spinner').removeClass('d-none');
                    },
                    success: function(response) {
                        append_message(response);
                        $('#conversation_spinner').addClass('d-none');
                        $('#conversation_icon').removeClass('d-none');
                    },
                    error: function(response) {
                        $('#conversation_spinner').addClass('d-none');
                        $('#conversation_icon').removeClass('d-none');
                        toastr.error(response.responseJSON.message, 'Error!', {
                            "showMethod": "slideDown",
                            "hideMethod": "slideUp",
                            timeOut: 4000
                        });
                    }
                });
            }
        }


        $('#delete_conversation_btn').on('click', function() {
            if (patient_id) {
                $.ajax({
                    url: "{{ route('conversation.destroy') }}",
                    type: "post",
                    data: {
                        patient_id: patient_id,
                    },
                    beforeSend: function() {
                        $('#conversation_icon').addClass('d-none');
                        $('#conversation_spinner').removeClass('d-none');
                    },
                    success: function(response) {

                        toastr.success('A new conversation has been created', 'Success!', {
                            "showMethod": "slideDown",
                            "hideMethod": "slideUp",
                            timeOut: 4000
                        });
                        location.reload();
                    },
                    error: function(response) {
                        $('#conversation_spinner').addClass('d-none');
                        $('#conversation_icon').removeClass('d-none');
                        toastr.error(response.responseJSON.message, 'Error!', {
                            "showMethod": "slideDown",
                            "hideMethod": "slideUp",
                            timeOut: 4000
                        });
                    }
                })
            }
        });
    </script>

    <script></script>
@endsection
