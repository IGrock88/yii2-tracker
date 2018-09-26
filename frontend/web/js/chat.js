(function launchChat() {
    var DEFAULT_PORT = 8080;
    var SCROLL_ANIMATE_TIME = 200;
    var START_MESSAGE_SYMBOLS = '>>';
    var ENTER_KEYCODE = 13;

    var webSocketPort = wsPort ? wsPort : DEFAULT_PORT;

    var conn = new WebSocket('ws://localhost:' + webSocketPort);

    conn.onopen = function(e) {
        console.log("Connection established!");
        conn.send(idProject);
    };
    conn.onmessage = function(e) {
        console.log(e);
        var chatArea = $('#chatArea');
        chatArea.val(chatArea.val() + START_MESSAGE_SYMBOLS + e.data + '\n');
        chatArea.animate({
            scrollTop : chatArea[0].scrollHeight - chatArea[0].clientHeight
        }, SCROLL_ANIMATE_TIME);

    };
    $('#sendMessage').on('click', function () {
        sendMessage();
        $('#messageInput').focus();
    });

    $('#messageInput').on('keydown', function (e) {
       if ($(this).is(':focus') && e.keyCode === ENTER_KEYCODE){
           sendMessage();
       }
    });

    function sendMessage() {
        var messageInput = $('#messageInput');
        if( messageInput.val().length != 0){
            conn.send(messageInput.val());
            messageInput.val('');
        }
    }
})();




