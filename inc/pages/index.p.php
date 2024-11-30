<?php
/**
 * @file index.p.php
 * @brief Direct Chat Page
 * @details
 * This file contains the implementation of a direct chat feature for a restaurant management system.
 * It includes both the HTML structure and the JavaScript logic for sending and fetching messages.
 *
 * PHP Section:
 * - Checks if a user session is active.
 * - Displays a chat interface with a message input form.
 * - The sender's username is retrieved from the session and included as a hidden input.
 *
 * JavaScript Section:
 * - Uses jQuery to handle form submission and AJAX requests.
 * - Prevents the default form submission behavior and sends an AJAX POST request to 'submit_message' endpoint.
 * - On successful message submission, the input field is cleared and messages are fetched again.
 * - Fetches messages from the 'fetch_messages' endpoint every 2 seconds.
 * - Updates the chat body with new messages and scrolls to the bottom if new messages are added.
 *
 * HTML Structure:
 * - A card component with a header, body, and footer.
 * - The body contains a div for displaying messages.
 * - The footer contains a form for sending new messages.
 *
 * AJAX Endpoints:
 * - 'submit_message': Handles the submission of new messages.
 * - 'fetch_messages': Retrieves the latest messages for the chat.
 *
 * JavaScript Functions:
 * - fetchMessages(): Fetches and updates the chat messages.
 * - scrollChatToBottom(): Scrolls the chat body to the bottom.
 *
 * Dependencies:
 * - jQuery library (version 3.5.1)
 * 
 * @package RestaurantManagement
 * @author Bancos Gabriel
 * @date 2024-11-30
 */
 ?>
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