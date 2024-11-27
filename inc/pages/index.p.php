<?php if(isset($_SESSION['user'])) { ?>
<div class="app-content">
    <div class="container-fluid"> 
        <div class="row"> 
            <div class="col-md-12">
                <div class="card direct-chat direct-chat-primary mb-4" id="direct-chat">
                    <div class="card-header">
                        <h3 class="card-title">Direct Chat</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-lte-toggle="card-collapse"> 
                                    <i data-lte-icon="expand" class="bi bi-plus-lg"></i> 
                                    <i data-lte-icon="collapse" class="bi bi-dash-lg"></i> 
                                </button> 
                            </div>
                    </div> 

                    <div class="card-body">
                        <div class="direct-chat-messages" id="direct-chat-body">
                            
                        </div>
                    </div>

                    <div class="card-footer" id="chat-form">
                        <form method="POST">
                            <div class="input-group"> <input type="text" id = "message" name="message" placeholder="Type Message ..." class="form-control"> 
                                <span class="input-group-append"> 
                                    <input type="hidden" id="sender" value="<?php echo $_SESSION['user'] ?>">
                                    <button type="submit" name = "sendMessage" class="btn btn-primary">Send</button> 
                                </span> 
                            </div>
                        </form>
                    </div>

                </div> 
            </div> 
            <?php } ?>
        </div> 
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>

$(document).ready(function() {
    let previousMessageCount = 0;
    $('#chat-form').submit(function(e) {
        e.preventDefault();
        var sender = $('#sender').val();
        var message = $('#message').val();

        $.ajax({
            url: 'submit_message',
            type: 'POST',
            data: {sender: sender, message: message},
            success: function() {
                $('#message').val('');
                fetchMessages(); 
            },
            error: function() {
                console.error("Error sending message");
            }
        });
    });

    function fetchMessages() {
        var sender = $('#sender').val();     
        $.ajax({
            url: 'fetch_messages', 
            type: 'POST',
            data: { sender: sender },
            success: function(data) {
                $('#direct-chat-body').html(data);
                let newMessageCount = $('#direct-chat-body').children().length;
                if (newMessageCount > previousMessageCount)
                    scrollChatToBottom();

                previousMessageCount = newMessageCount;
            },
            error: function() {
                console.error("Error fetching messages");
            }
        });
    } 

    function scrollChatToBottom() {
        var chatBox = $('#direct-chat-body');
        chatBox.scrollTop(chatBox.prop("scrollHeight"));
    }

    fetchMessages();
    setInterval(fetchMessages, 2000);
});

</script>