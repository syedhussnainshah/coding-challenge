<div class="row justify-content-center mt-5">
    <div class="col-12">
        <div class="card shadow  text-white bg-dark">
            <div class="card-header">Coding Challenge - Network connections</div>
            <div class="card-body">
                <div class="btn-group w-100 mb-3" role="group" aria-label="Basic radio toggle button group">
                    <input type="radio" class="btn-check" name="btnradio" id="btnradio1" autocomplete="off" checked>
                    <label class="btn btn-outline-primary" for="btnradio1" id="get_suggestions_btn">Suggestions
                        ()</label>

                    <input type="radio" class="btn-check" name="btnradio" id="btnradio2" autocomplete="off">
                    <label class="btn btn-outline-primary" for="btnradio2" id="get_sent_requests_btn">Sent Requests
                        ()</label>

                    <input type="radio" class="btn-check" name="btnradio" id="btnradio3" autocomplete="off">
                    <label class="btn btn-outline-primary" for="btnradio3" id="get_received_requests_btn">Received
                        Requests()</label>

                    <input type="radio" class="btn-check" name="btnradio" id="btnradio4" autocomplete="off">
                    <label class="btn btn-outline-primary" for="btnradio4" id="get_connectionss_btn">Connections
                        ()</label>
                </div>
                <hr>
                <div id="content" class="d-none">
                </div>

                {{-- Remove this when you start working, just to show you the different components --}}
                {{-- <span class="fw-bold">Sent Request Blade</span>
                <x-request :mode="'sent'" />

                <span class="fw-bold">Received Request Blade</span>
                <x-request :mode="'received'" />

                <span class="fw-bold">Suggestion Blade</span>
                <x-suggestion />

                <span class="fw-bold">Connection Blade (Click on "Connections in common" to see the connections in
                    common
                    component)</span>
                <x-connection /> --}}
                {{-- Remove this when you start working, just to show you the different components --}}

                <div id="skeleton" class="d-none">
                    @for ($i = 0; $i < 10; $i++)
                        <x-skeleton />
                    @endfor
                </div>

                <span class="fw-bold">"Load more"-Button</span>
                <div class="d-flex justify-content-center mt-2 py-3 {{-- d-none --}}" id="load_more_btn_parent">
                    <button class="btn btn-primary" onclick="" id="load_more_btn">Load more</button>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Remove this when you start working, just to show you the different components --}}

<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
    crossorigin="anonymous"></script>
<script>
    $(document).ready(function() {
        getSuggestion();
        $("#get_suggestions_btn").on('click', function() {
            getSuggestion();
        });
        $("#get_sent_requests_btn").on('click', function() {
            getSentRequests();
        });
        $("#get_received_requests_btn").on('click', function() {
            getReceivedRequests();
        });
        $("#get_connectionss_btn").on('click', function() {
            getConnectionss();
        });

    })

    function getSuggestion() {
        $(document).ready(function() {
            $.ajax({
                url: "{{ route('suggestions') }}",
                type: "GET",
                success: function(data) {
                    console.log(data.suggestions);
                    $("#content").html("");
                    $("#content").removeClass("d-none");
                    for (let i = 0; i < data.suggestions.length; i++) {
                        $("#content").append(data.suggestions[i]);
                        let SuggestionRows =
                            '<div class="my-2 shadow text-white bg-dark p-1" id=""><div class="d-flex justify-content-between"><table class="ms-1"><td class="align-middle">' +
                            data.suggestions[i].name +
                            '</td><td class="align-middle"> - </td><td class="align-middle">' +
                            data.suggestions[i].email +
                            '</td></table><div><button id="accept_request_btn_" class="btn btn-primary me-1" onclick="ConnectUser(' +
                            data.suggestions[i].id +
                            ')">Connect</button></div></div> </div>';
                        $("#content").append(SuggestionRows);
                    }
                }
            })
        });
    }

    function ConnectUser(user_id) {
        $(document).ready(function() {
            $.ajax({
                url: "{{ route('connect') }}",
                type: "POST",
                data: {
                    user_id: user_id,
                    _token: "{{ csrf_token() }}",
                },
                success: function(data) {
                    getSuggestion();

                }
            })
        });
    }

    function getSentRequests() {
        $(document).ready(function() {
            $.ajax({
                url: "{{ route('sent_requests') }}",
                type: "GET",
                success: function(data) {
                    $("#content").html("");
                    $("#content").removeClass("d-none");
                    for (let i = 0; i < data.sent_requests.length; i++) {
                        console.log(data.sent_requests[i].user.name);
                        console.log(data.sent_requests[i])
                        console.log("REquested");
                        $("#content").append(data.sent_requests[i]);
                        let SentRequestRows =
                            '<div class="my-2 shadow text-white bg-dark p-1" id=""><div class="d-flex justify-content-between"><table class="ms-1"><td class="align-middle">' +
                            data.sent_requests[i].user.name +
                            '</td><td class="align-middle"> - </td><td class="align-middle">' +
                            data.sent_requests[i].user.email +
                            '</td></table><div><button id="accept_request_btn_" class="btn btn-danger me-1" onclick="WithdrawRequest(' +
                            data.sent_requests[i].id +
                            ')">Withdraw Request</button></div></div> </div>';
                        $("#content").append(SentRequestRows);
                    }
                }
            })
        });
    }

    function WithdrawRequest(id) {
        $(document).ready(function() {
            $.ajax({
                url: "{{ route('withdraw_request') }}",
                type: "POST",
                data: {
                    id: id,
                    _token: "{{ csrf_token() }}",
                },
                success: function(data) {
                    getSentRequests();

                }
            })
        });
    }

    function getReceivedRequests() {
        $(document).ready(function() {
            $.ajax({
                url: "{{ route('received_requests') }}",
                type: "GET",
                success: function(data) {
                    $("#content").html("");
                    $("#content").removeClass("d-none");
                    for (let i = 0; i < data.received_requests.length; i++) {

                        $("#content").append(data.received_requests[i]);
                        let ReceivedRequestRows =
                            '<div class="my-2 shadow text-white bg-dark p-1" id=""><div class="d-flex justify-content-between"><table class="ms-1"><td class="align-middle">' +
                            data.received_requests[i].connection.name +
                            '</td><td class="align-middle"> - </td><td class="align-middle">' +
                            data.received_requests[i].connection.email +
                            '</td></table><div><button id="accept_request_btn_" class="btn btn-primary me-1" onclick="AcceptRequest(' +
                            data.received_requests[i].id +
                            ')">Accept</button></div></div> </div>';
                        $("#content").append(ReceivedRequestRows);
                    }
                }
            })
        });
    }

    function AcceptRequest(id) {
        $(document).ready(function() {
            $.ajax({
                url: "{{ route('accept_request') }}",
                type: "POST",
                data: {
                    id: id,
                    _token: "{{ csrf_token() }}",
                },
                success: function(data) {
                    getReceivedRequests();

                }
            })
        });
    }

    function getConnectionss() {

        $(document).ready(function() {
            $.ajax({
                url: "{{ route('connections') }}",
                type: "GET",
                success: function(data) {
                    console.log(data);
                    $("#content").html("");
                    $("#content").removeClass("d-none");
                    for (let i = 0; i < data.connections.length; i++) {
                        console.log(data.connections[i].user.name);
                        console.log(data.connections[i])
                        let ConnectionRows =
                            '<div class="my-2 shadow text-white bg-dark p-1" id=""><div class="d-flex justify-content-between"><table class="ms-1"><td class="align-middle">' +
                            data.connections[i].user.name +
                            '</td><td class="align-middle"> - </td><td class="align-middle">' +
                            data.connections[i].user.email +
                            '</td></table><div><p><a class="btn btn-primary" data-bs-toggle="collapse" href="#collapseExample' +
                            data.connections[i].id +
                            '" role="button" aria-expanded="false" aria-controls="collapseExample">Connection in Common</a></p><div class="collapse" id="collapseExample' +
                            data.connections[i].id +
                            '"><div class="my-2 shadow text-white bg-dark p-1" >';
                        for (let j = 0; j < data.connections[i].common_connections.length; j++) {
                            ConnectionRows += data.connections[i].common_connections[j].connection
                                .name +
                                " - " + data.connections[i].common_connections[j].connection.email +
                                "<br>";
                        }


                        ConnectionRows += 'Show Common name</div></div><button onclick="RemoveConnections(' +
                            data.connections[i].id +
                            ')" class="btn btn-danger">Remove Connection</button></div></div> </div>';
                        $("#content").append(ConnectionRows);
                    }
                    for (let i = 0; i < data.connectionsOtherSide.length; i++) {
                        let ConnectionRows =
                            '<div class="my-2 shadow text-white bg-dark p-1" id=""><div class="d-flex justify-content-between"><table class="ms-1"><td class="align-middle">' +
                            data.connectionsOtherSide[i].connection.name +
                            '</td><td class="align-middle"> - </td><td class="align-middle">' +
                            data.connectionsOtherSide[i].connection.email +
                            '</td></table><div><p><a class="btn btn-primary" data-bs-toggle="collapse" href="#collapseExampleOther' +
                            data.connectionsOtherSide[i].id +
                            '" role="button" aria-expanded="false" aria-controls="collapseExample">Connection In Common</a></p><div class="collapse" id="collapseExampleOther' +
                            data.connectionsOtherSide[i].id +
                            '">   <div class="my-2 shadow text-white bg-dark p-1" >';
                        for (let j = 0; j < data.connectionsOtherSide[i].common_connections
                            .length; j++) {
                            ConnectionRows += data.connectionsOtherSide[i].common_connections[j]
                                .connection
                                .name +
                                " - " + data.connectionsOtherSide[i].common_connections[j]
                                .connection.email +
                                "<br>";
                        }
                        for (let k = 0; k < data.connectionsOtherSide[i]
                            .common_connections_other_side
                            .length; k++) {
                            ConnectionRows += data.connectionsOtherSide[i]
                                .common_connections_other_side[k]
                                .connection
                                .name +
                                " - " + data.connectionsOtherSide[i].common_connections_other_side[
                                    k]
                                .connection.email +
                                "<br>";
                        }
                        ConnectionRows +=
                            'Show Common name</div></div><button onclick="RemoveConnections(' +
                            data.connectionsOtherSide[i].id +
                            ')" class="btn btn-danger">Remove Connection</button></div></div> </div>';
                        $("#content").append(ConnectionRows);
                    }
                }
            })
        });
    }

    function RemoveConnections(id) {
        $(document).ready(function() {
            $.ajax({
                url: "{{ route('remove_connection') }}",
                type: "POST",
                data: {
                    id: id,
                    _token: "{{ csrf_token() }}",
                },
                success: function(data) {
                    getConnectionss();

                }
            })
        });
    }
</script>
