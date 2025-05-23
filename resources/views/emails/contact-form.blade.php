<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Nuevo mensaje de contacto</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background-color: #4a90e2;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 5px 5px 0 0;
        }
        .content {
            background-color: #f9f9f9;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 0 0 5px 5px;
        }
        .field {
            margin-bottom: 15px;
        }
        .field-label {
            font-weight: bold;
            color: #666;
        }
        .field-value {
            margin-top: 5px;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            color: #666;
            font-size: 0.9em;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Nuevo mensaje de contacto</h1>
    </div>
    
    <div class="content">
        <div class="field">
            <div class="field-label">Nombre:</div>
            <div class="field-value">{{ $data['name'] }}</div>
        </div>
        
        <div class="field">
            <div class="field-label">Email:</div>
            <div class="field-value">{{ $data['email'] }}</div>
        </div>
        
        <div class="field">
            <div class="field-label">Asunto:</div>
            <div class="field-value">{{ $data['subject'] }}</div>
        </div>
        
        <div class="field">
            <div class="field-label">Mensaje:</div>
            <div class="field-value">{{ $data['message'] }}</div>
        </div>
    </div>
    
    <div class="footer">
        <p>Este mensaje fue enviado desde el formulario de contacto de PinCode.</p>
    </div>
</body>
</html> 