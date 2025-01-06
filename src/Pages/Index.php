<?php 
if(!isset($_SESSION['user'])) 
    return; 

use App\Config\Config;
use App\Controller\ChatMessagesController;

$dbConnection = Config::getDatabase();
$chatController = new ChatMessagesController($dbConnection);
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['sendMessage'])) {
        $chatController->submitMessage();
    } elseif (isset($_POST['fetchMessages'])) {
        $chatController->fetchMessages();
    }
}
?>
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
                            <!-- Messages goes here -->
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
        </div>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        let previousMessageCount = 0;

        // Handle form submission
        $('#chat-form').submit(function(e) {
            e.preventDefault();  // Prevent the default form submission behavior
            
            var sender = $('#sender').val();  // Get sender ID from hidden input
            var message = $('#message').val(); // Get message from the input field

            // Check if message is not empty
            if (message.trim() !== '') {
                $.ajax({
                    url: '/index.php',  // Point to the same page for submission
                    type: 'POST',
                    data: { sender: sender, message: message, sendMessage: true },  // Send data and indicate message submission
                    success: function() {
                        $('#message').val('');  // Clear the message input field
                        fetchMessages();  // Fetch updated messages
                    },
                    error: function() {
                        console.error("Error sending message");
                    }
                });
            }
        });

        // Fetch messages for the sender's group
        function fetchMessages() {
            var sender = $('#sender').val();  // Get sender ID from hidden input

            $.ajax({
                url: '/index.php',  // Point to the same page for fetching messages
                type: 'POST',
                data: { sender: sender, fetchMessages: true },  // Send request to fetch messages
                success: function(data) {
                    $('#direct-chat-body').html(data);  // Update the chat body with new messages

                    let newMessageCount = $('#direct-chat-body').children().length;
                    
                    // If new messages have been added, scroll to the bottom
                    if (newMessageCount > previousMessageCount) {
                        scrollChatToBottom();
                    }

                    previousMessageCount = newMessageCount;  // Update the message count tracker
                },
                error: function() {
                    console.error("Error fetching messages");
                }
            });
        }

        // Scroll to the bottom of the chat window
        function scrollChatToBottom() {
            var chatBox = $('#direct-chat-body');
            chatBox.scrollTop(chatBox.prop("scrollHeight"));
        }

        // Initial fetch of messages
        fetchMessages();
        
        // Periodically fetch new messages every 2 seconds
        setInterval(fetchMessages, 2000);
    });
</script>