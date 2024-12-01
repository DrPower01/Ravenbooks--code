<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <style>
        /* Reusing your existing styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            list-style: none;
            font-family: "Times New Roman", sans-serif;
        }

        .login-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f9f9f9;
            padding: 20px; /* Add padding for smaller screens */
        }

        .login-box {
            background-color: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px; /* Limit width */
            text-align: center;
        }

        h2 {
            font-size: 28px;
            color: #333;
            margin-bottom: 20px;
        }

        .login-button {
            background-color: #333;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            margin-top: 20px;
            font-size: 16px;
            width: 100%; /* Full width button */
        }

        .login-button:hover {
            background-color: #555;
        }

        /* Facebook button styles */
        .fb-login-button {
            background-color: #3b5998;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            margin-top: 20px;
            font-size: 16px;
            width: 100%; /* Full width button */
        }

        .fb-login-button:hover {
            background-color: #4c70a0;
        }

        /* Responsive styling */
        @media (max-width: 768px) {
            .login-box {
                padding: 30px; /* Reduce padding for smaller screens */
            }

            h2 {
                font-size: 24px; /* Reduce font size */
            }

            .login-button, .fb-login-button {
                font-size: 14px; /* Smaller button text */
            }
        }

        @media (max-width: 480px) {
            .login-box {
                padding: 20px; /* Further reduce padding */
            }

            h2 {
                font-size: 20px; /* Smaller title */
            }

            .login-button, .fb-login-button {
                font-size: 12px; /* Smaller button text */
            }
        }
    </style>
</head>
<body>

<div class="login-container">
    <div class="login-box">
        <h2>Login</h2>
        <p>Please click below to sign in with your Google or Facebook account.</p>

        <!-- Google Login Button -->
        <button class="login-button" onclick="signInWithGoogle()">Sign in with Google</button>

        <!-- Facebook Login Button -->
        <button class="fb-login-button" onclick="signInWithFacebook()">Sign in with Facebook</button>
    </div>
</div>

<!-- Load Facebook SDK -->
<script async defer src="https://connect.facebook.net/en_US/sdk.js" crossorigin="anonymous"></script>

<script>
    // Initialize Facebook SDK
    window.fbAsyncInit = function() {
        FB.init({
            appId      : 'YOUR_FACEBOOK_APP_ID', // Replace with your Facebook App ID
            cookie     : true,
            xfbml      : true,
            version    : 'v15.0'
        });
    };

    // Sign in with Google (Placeholder)
    function signInWithGoogle() {
        // Replace with your Google auth logic
        window.location.href = "https://accounts.google.com/signin";
    }

    // Sign in with Facebook
    function signInWithFacebook() {
        FB.login(function(response) {
            if (response.authResponse) {
                console.log('Facebook login successful');
                // You can now use response.authResponse to get the user info
                FB.api('/me', function(profile) {
                    console.log('Logged in as: ' + profile.name);
                    // Process the user data as needed, e.g., send to your server for authentication
                });
            } else {
                console.log('Facebook login failed');
            }
        }, { scope: 'public_profile,email' });
    }
</script>

</body>
</html>
