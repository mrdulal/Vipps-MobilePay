<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vipps Express Checkout</title>
    <style>
        .vipps-express-button {
            display: inline-block;
            padding: 12px 24px;
            background-color: #ff5b2c;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-family: Arial, sans-serif;
            font-weight: bold;
            font-size: 16px;
            transition: background-color 0.3s ease;
            border: none;
            cursor: pointer;
        }

        .vipps-express-button:hover {
            background-color: #e54a24;
        }

        .vipps-express-button.white {
            background-color: white;
            color: #ff5b2c;
            border: 2px solid #ff5b2c;
        }

        .vipps-express-button.white:hover {
            background-color: #f8f8f8;
        }

        .vipps-express-button.white-outline {
            background-color: transparent;
            color: #ff5b2c;
            border: 2px solid #ff5b2c;
        }

        .vipps-express-button.white-outline:hover {
            background-color: #ff5b2c;
            color: white;
        }

        .vipps-express-button.small {
            padding: 8px 16px;
            font-size: 14px;
        }

        .vipps-express-button.medium {
            padding: 10px 20px;
            font-size: 15px;
        }

        .vipps-express-button.large {
            padding: 12px 24px;
            font-size: 16px;
        }
    </style>
</head>
<body>
    <button 
        id="vipps-express-button" 
        class="vipps-express-button {{ $theme ?? 'orange' }} {{ $size ?? 'large' }}"
        onclick="initiateVippsExpress()"
    >
        {{ $text ?? 'Pay with Vipps' }}
    </button>

    <script>
        function initiateVippsExpress() {
            // This would be replaced with actual Vipps Express checkout logic
            const expressData = {
                amount: {{ $amount ?? 0 }},
                currency: '{{ $currency ?? "NOK" }}',
                orderId: '{{ $orderId ?? "" }}',
                description: '{{ $description ?? "" }}',
                redirectUrl: '{{ $redirectUrl ?? "" }}'
            };

            // Make AJAX call to create express checkout session
            fetch('/vipps/express/create', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify(expressData)
            })
            .then(response => response.json())
            .then(data => {
                if (data.url) {
                    window.location.href = data.url;
                } else {
                    console.error('Failed to create express checkout session');
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }
    </script>
</body>
</html>