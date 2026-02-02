<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>System Error | {{ config('app.name') }}</title>
    <link rel="stylesheet" href="{{ asset('css/font-awesome.css') }}">
    <style>
        :root {
            --primary: #3490dc;
            --danger: #e3342f;
            --light: #f8f9fa;
            --dark: #343a40;
        }
        
        body {
            font-family: 'Nunito', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Arial, sans-serif;
            background-color: #f5f7fa;
            color: #333;
            line-height: 1.6;
            margin: 0;
            padding: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        
        .error-container {
            max-width: 600px;
            width: 90%;
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            animation: fadeIn 0.5s ease-out;
        }
        
        .error-header {
            background: var(--danger);
            color: white;
            padding: 20px;
            text-align: center;
        }
        
        .error-header i {
            font-size: 2.5rem;
            margin-bottom: 10px;
        }
        
        .error-body {
            padding: 30px;
        }
        
        .error-title {
            color: var(--danger);
            margin-top: 0;
            font-size: 1.5rem;
        }
        
        .error-details {
            background: var(--light);
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
            font-size: 0.9rem;
        }
        
        .error-code {
            font-weight: bold;
            color: var(--dark);
        }
        
        .action-buttons {
            display: flex;
            gap: 10px;
            margin-top: 25px;
            flex-wrap: wrap;
        }
        
        .btn {
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
        }
        
        .btn-primary {
            background: var(--primary);
            color: white;
        }
        
        .btn-secondary {
            background: var(--light);
            color: var(--dark);
            border: 1px solid #ddd;
        }
        
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        @media (max-width: 480px) {
            .error-container {
                width: 95%;
            }
            .action-buttons {
                flex-direction: column;
            }
            .btn {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
</head>
<body>
    <div class="error-container">
        <div class="error-header">
            <i class="fas fa-exclamation-triangle"></i>
            <h1>System Error Occurred</h1>
        </div>
        
        <div class="error-body">
            <h2 class="error-title">We're sorry, something went wrong</h2>
            
            <p>Our technical team has been notified about this issue. Please try again later.</p>
            
            @if(!config('app.debug') && isset($exception))
            <div class="error-details">
                <p>For support, please contact our administrator with this error reference:</p>
                <p class="error-code">Error ID: {{ $errorCode ?? substr(md5(now()), 0, 10) }}</p>
            </div>
            @endif
            
            <div class="action-buttons">
                <a href="{{ url('/home') }}" class="btn btn-primary">
                    <i class="fas fa-home"></i> Return Home
                </a>
                <a href="mailto:isac@i5tech.in" class="btn btn-secondary">
                    <i class="fas fa-envelope"></i> Contact Admin
                </a>

            </div>
        </div>
    </div>
</body>
</html>