<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Username Checker</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 40px;
            width: 100%;
            max-width: 500px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 30px;
            font-size: 2.5em;
            font-weight: 700;
            background: linear-gradient(135deg, #667eea, #764ba2);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .subtitle {
            text-align: center;
            color: #666;
            margin-bottom: 40px;
            font-size: 1.1em;
        }

        .input-group {
            position: relative;
            margin-bottom: 30px;
        }

        .input-container {
            position: relative;
            display: flex;
            align-items: center;
        }

        input[type="text"] {
            width: 100%;
            padding: 18px 60px 18px 20px;
            border: 2px solid #e0e0e0;
            border-radius: 12px;
            font-size: 16px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            background: #fafafa;
            outline: none;
        }

        input[type="text"]:focus {
            border-color: #667eea;
            background: white;
            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
            transform: translateY(-2px);
        }

        .status-icon {
            position: absolute;
            right: 20px;
            width: 24px;
            height: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: all 0.3s ease;
        }

        .status-icon.show {
            opacity: 1;
            transform: scale(1.1);
        }

        .loading-spinner {
            border: 2px solid #f3f3f3;
            border-top: 2px solid #667eea;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        .check-icon {
            color: #4caf50;
            font-size: 20px;
            font-weight: bold;
        }

        .error-icon {
            color: #f44336;
            font-size: 20px;
            font-weight: bold;
        }

        .message {
            margin-top: 15px;
            padding: 15px;
            border-radius: 10px;
            font-weight: 500;
            opacity: 0;
            transition: all 0.3s ease;
            transform: translateY(-10px);
        }

        .message.show {
            opacity: 1;
            transform: translateY(0);
        }

        .message.success {
            background: rgba(76, 175, 80, 0.1);
            color: #4caf50;
            border: 1px solid rgba(76, 175, 80, 0.3);
        }

        .message.error {
            background: rgba(244, 67, 54, 0.1);
            color: #f44336;
            border: 1px solid rgba(244, 67, 54, 0.3);
        }

        .character-count {
            font-size: 14px;
            color: #666;
            margin-top: 8px;
            text-align: right;
        }

        .tips {
            background: rgba(102, 126, 234, 0.1);
            border: 1px solid rgba(102, 126, 234, 0.2);
            border-radius: 10px;
            padding: 20px;
            margin-top: 30px;
        }

        .tips h3 {
            color: #667eea;
            margin-bottom: 10px;
            font-size: 1.1em;
        }

        .tips ul {
            list-style: none;
            color: #666;
        }

        .tips li {
            padding: 5px 0;
            position: relative;
            padding-left: 20px;
        }

        .tips li:before {
            content: "✓";
            position: absolute;
            left: 0;
            color: #667eea;
            font-weight: bold;
        }

        .pulse-animation {
            animation: pulse 0.6s ease-in-out;
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.05);
            }

            100% {
                transform: scale(1);
            }
        }

        @media (max-width: 600px) {
            .container {
                padding: 30px 20px;
                margin: 20px;
            }

            h1 {
                font-size: 2em;
            }

            input[type="text"] {
                padding: 16px 50px 16px 18px;
                font-size: 16px;
            }
        }

        .footer {
            text-align: center;
            margin-top: 30px;
            color: #666;
            font-size: 14px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Username Checker</h1>
        <p class="subtitle">Periksa ketersediaan username secara real-time</p>

        <div class="input-group">
            <div class="input-container">
                <input type="text" id="usernameInput" placeholder="Masukkan username yang diinginkan..."
                    autocomplete="off">
                <div class="status-icon" id="statusIcon">
                    <div class="loading-spinner" id="loadingSpinner" style="display: none;"></div>
                    <div class="check-icon" id="checkIcon" style="display: none;">✓</div>
                    <div class="error-icon" id="errorIcon" style="display: none;">✗</div>
                </div>
            </div>
            <div class="character-count" id="charCount">0 karakter</div>
        </div>

        <div class="message" id="messageBox"></div>

        <div class="tips">
            <h3>Tips Username:</h3>
            <ul>
                <li>Minimal 3 karakter</li>
                <li>Gunakan huruf, angka, dan underscore</li>
                <li>Hindari karakter khusus</li>
                <li>Buat yang mudah diingat</li>
            </ul>
        </div>

        <div class="footer">
            <p>Username akan dicek otomatis saat Anda mengetik</p>
        </div>
    </div>

    <script>
        let checkTimeout;
        const usernameInput = document.getElementById('usernameInput');
        const statusIcon = document.getElementById('statusIcon');
        const loadingSpinner = document.getElementById('loadingSpinner');
        const checkIcon = document.getElementById('checkIcon');
        const errorIcon = document.getElementById('errorIcon');
        const messageBox = document.getElementById('messageBox');
        const charCount = document.getElementById('charCount');

        // Update character count
        function updateCharCount(length) {
            charCount.textContent = `${length} karakter`;
            if (length < 3) {
                charCount.style.color = '#f44336';
            } else {
                charCount.style.color = '#666';
            }
        }

        // Show loading state
        function showLoading() {
            hideAllIcons();
            loadingSpinner.style.display = 'block';
            statusIcon.classList.add('show');
        }

        // Show success state
        function showSuccess() {
            hideAllIcons();
            checkIcon.style.display = 'block';
            statusIcon.classList.add('show');
            statusIcon.classList.add('pulse-animation');
            setTimeout(() => statusIcon.classList.remove('pulse-animation'), 600);
        }

        // Show error state
        function showError() {
            hideAllIcons();
            errorIcon.style.display = 'block';
            statusIcon.classList.add('show');
            statusIcon.classList.add('pulse-animation');
            setTimeout(() => statusIcon.classList.remove('pulse-animation'), 600);
        }

        // Hide all icons
        function hideAllIcons() {
            loadingSpinner.style.display = 'none';
            checkIcon.style.display = 'none';
            errorIcon.style.display = 'none';
            statusIcon.classList.remove('show');
        }

        // Show message
        function showMessage(message, type) {
            messageBox.textContent = message;
            messageBox.className = `message ${type} show`;
        }

        // Hide message
        function hideMessage() {
            messageBox.classList.remove('show');
        }

        // Check username availability function (replace with your actual implementation)
        async function checkUsernameAvailability(username) {
            if (username.length < 3) {
                return { available: false, message: 'Username minimal 3 karakter' };
            }

            // Simulate API call - replace this with your actual PHP endpoint
            // For demo purposes, we'll simulate different responses
            return new Promise((resolve) => {
                setTimeout(() => {
                    // Simulate different responses based on username
                    if (username.toLowerCase().includes('admin') || username.toLowerCase().includes('test')) {
                        resolve({ available: false, message: 'Username sudah digunakan' });
                    } else if (username.length >= 3) {
                        resolve({ available: true, message: 'Username tersedia!' });
                    } else {
                        resolve({ available: false, message: 'Username tidak valid' });
                    }
                }, 800); // Simulate network delay
            });
        }

        // Handle username input
        usernameInput.addEventListener('input', function () {
            const username = this.value.trim();
            updateCharCount(username.length);

            // Clear previous timeout
            clearTimeout(checkTimeout);

            if (username.length === 0) {
                hideAllIcons();
                hideMessage();
                return;
            }

            if (username.length < 3) {
                showError();
                showMessage('Username minimal 3 karakter', 'error');
                return;
            }

            // Show loading immediately
            showLoading();
            hideMessage();

            // Debounce the API call
            checkTimeout = setTimeout(async () => {
                try {
                    const result = await checkUsernameAvailability(username);

                    if (result.available) {
                        showSuccess();
                        showMessage(result.message, 'success');
                    } else {
                        showError();
                        showMessage(result.message, 'error');
                    }
                } catch (error) {
                    showError();
                    showMessage('Terjadi kesalahan saat memeriksa username', 'error');
                }
            }, 500); // Wait 500ms after user stops typing
        });

        // Add focus animation
        usernameInput.addEventListener('focus', function () {
            this.parentElement.parentElement.classList.add('pulse-animation');
            setTimeout(() => {
                this.parentElement.parentElement.classList.remove('pulse-animation');
            }, 600);
        });

        // Initialize character count
        updateCharCount(0);
    </script>
</body>

</html>
