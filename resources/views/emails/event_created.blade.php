<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <link href="https://fonts.googleapis.com/css2?family=Gotu&family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Gotu&family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap" rel="stylesheet">
    <title>Potvrdenie rezervácie</title>
    <style>
        body {
            font-family: 'Inter', sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #fff;
        }
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: #B89080;
            text-align: center;
            font-family: 'Gotu', sans-serif;
        }
        p {
            color: #B19D9C;
            font-size: 16px;
            line-height: 1.5;
            text-align: center;
        }
        ul {
            list-style: none;
            padding: 0;
        }
        ul li {
            color: #B19D9C;
            font-size: 16px;
            padding: 8px 0;
            border-bottom: 1px solid #ddd;
        }
        ul li strong {
            color: #B89080;
            font-weight: 300;
        }
        ul li:last-child {
            border-bottom: none;
        }
        .footer {
            margin-top: 20px;
            text-align: center;
            color: #B89080;
            font-size: 14px;
        }
        .footer p {
            color: #B89080;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <h1>Potvrdenie rezervácie</h1>
        <p>Vážený/á {{ $details['name'] }} {{ $details['surname'] }},</p>
        <p>Vaša rezervácia bola úspešne vytvorená!</p>
        <ul>
            <li><strong>Príchod:</strong> {{ $details['arrival'] }}</li>
            <li><strong>Odchod:</strong> {{ $details['departure'] }}</li>
            <li><strong>Počet hostí:</strong> {{ $details['guests'] }}</li>
            <li><strong>Celková cena:</strong> {{ $details['total_cost'] }}€</li>
        </ul>
        <p>Ďakujeme, že ste si vybrali naše služby!</p>
        <div class="footer">
            <p>&copy; 2025 stayparkfive.com</p>
        </div>
    </div>
</body>
</html>
