<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Chat</title>
</head>
<body>
    <div id="chat-container">
        <div id="messages">

        </div>
        <form id="chat-form" method="POST" action="{{ route('chatty.send') }}">
            @csrf 
            <input type="text" id="message" name="message" placeholder="Ask the AI..." required>
            <button type="submit">Send</button>
        </form>
    </div>

    <!-- <script>
            document.getElementById('chat-form').addEventListener('submit', async (e) => {
            e.preventDefault(); // Prevent the form from refreshing the page

            // Get the message from the input field
            const message = document.getElementById('message').value;

            // Ensure the message isn't empty
            if (!message.trim()) {
                alert('Please enter a message.');
                return;
            }

            // Make the POST request to your Laravel route
            try {
                const response = await fetch('{{ route('chatty.send') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ message }), // Use the correct variable
                });

                if (!response.ok) {
                    console.error('Failed to fetch AI response');
                    alert('Failed to fetch AI response');
                    return;
                }

                const data = await response.json();
                console.log('AI Response:', data);

                // Add AI response to the chat window
                const messagesContainer = document.getElementById('messages');
                messagesContainer.innerHTML += `<div class="ai-message">${data.choices[0].message.content}</div>`;

                // Clear the input field
                document.getElementById('message').value = '';
            } catch (error) {
                console.error('Error during fetch:', error);
                alert('Error: Unable to connect to the server.');
            }
        });
    </script> -->


</body>
</html>