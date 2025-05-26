<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Plan Subscription Confirmation</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Helvetica Neue', Arial, sans-serif;
            background-color: #111;
            color: #ffffff;
        }
        .container {
            max-width: 600px;
            margin: 40px auto;
            background-color: #111;
            color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 8px #333;
            overflow: hidden;
        }
        .header {
            background-color: #111;
            padding: 24px;
            text-align: center;
            border-bottom: 4px solid #333;
        }
        .header img.logo {
            max-width: 150px;
            height: auto;
            margin-bottom: 16px;
        }
        .header h1 {
            color: #ffffff;
            font-size: 24px;
            margin: 0;
            font-weight: 500;
        }
        .content {
            padding: 32px;
        }
        .section {
            margin-bottom: 32px;
        }
        .section-title {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 16px;
            border-bottom: 1px solid #333;
            padding-bottom: 8px;
        }
        .section-content {
            font-size: 16px;
            line-height: 1.6;
            color: #fff;
        }
        .section-content p {
            margin: 0 0 16px;
        }
        .field {
            display: flex;
            justify-content: space-between;
            margin-bottom: 12px;
            font-size: 15px;
        }
        .field .label {
            font-weight: 600;
            color: #777;
        }
        .field .value {
            color: #888;
        }
        .services-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        .services-list li {
            position: relative;
            padding-left: 24px;
            margin-bottom: 8px;
            font-size: 15px;
            color: #444444;
        }
        .services-list li::before {
            content: '✓';
            position: absolute;
            left: 0;
            color: #1a73e8;
            font-weight: bold;
        }
        .footer {
            background-color: #111;
            padding: 16px;
            text-align: center;
            font-size: 14px;
            color: #777777;
            border-top: 1px solid #333;
        }
        .footer p {
            margin: 0;
        }
        @media only screen and (max-width: 600px) {
            .container {
                margin: 20px;
                border-radius: 6px;
            }
            .header {
                padding: 16px;
            }
            .header h1 {
                font-size: 20px;
            }
            .content {
                padding: 20px;
            }
            .section-title {
                font-size: 16px;
            }
            .section-content {
                font-size: 14px;
            }
            .field {
                font-size: 14px;
                flex-direction: column;
                gap: 4px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            @if(isset($logo))
                <img src="{{ $logo }}" class="logo" style="height: 100px; width: 100px; object-fit: contain;">
            @endif
            <h1>Plan Subscription Confirmation</h1>
        </div>
        
        <div class="content">
            <div class="section">
                <div class="section-title">Hi {{ $username }}</div>
                <div class="section-content">
                    <p>
                        Thank you for subscribing to one of our plans! We're thrilled to have you on board and look forward to supporting your journey.
                        Below are the details of your selected plan. If you have any questions or need assistance, feel free to reply to this email.
                    </p>
                    <p>We’ll follow up shortly with the next steps.</p>
                    <p>Best regards, <br/>
                    {{ config('app.name') }} Team</p>
                </div>
            </div>
            
            <div class="section">
                <div class="section-title">Subscription Details</div>
                <div class="section-content">
                    @if(isset($plan))
                        <div class="field">
                            <span class="label">Plan Name:</span>
                            <span class="value">{{ $plan->name }}</span>
                        </div>
                    @endif
                    @if(isset($plan))
                        <div class="field">
                            <span class="label">Price:</span>
                            <span class="value">${{ number_format($plan->price, 2) }}</span>
                        </div>
                    @endif
                    @if(isset($billingCycle))
                        <div class="field">
                            <span class="label">Billing Cycle:</span>
                            <span class="value">{{ ucfirst($billingCycle) }}</span>
                        </div>
                    @endif
                    @if(isset($plan))
                        <div class="field">
                            <span class="label">Start Date:</span>
                            <span class="value">{{ \Carbon\Carbon::parse($plan->created_at)->format('F d, Y') }}</span>
                        </div>
                    @endif
                </div>
            </div>

            @if(isset($includedFeatures) && count($includedFeatures) > 0)
                <div class="section">
                    <div class="section-title">What's Included</div>
                    <div class="section-content">
                        <ul class="services-list">
                            @foreach($includedFeatures as $feature)
                                <li>{{ $feature }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif
        </div>

        <div class="footer">
            <p>© {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
        </div>
    </div>
</body>
</html>