<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restablecer contraseña - LiberArte</title>
    <style>
        body{
        background-color: #f5f5f5;
        font-family: 'Monserrat', Arial, Helvetica, sans-serif;
        margin: 0;
        padding: 40px 0;
    }

    .container{
        width: 600px;
        margin: auto;
        background: white;
        border-radius: 8px;
        padding: 40px;
        color: #333;
    }

    .logo{
        text-align:center;
        margin-bottom: 20px;
    }

    .title{
        text-align: center;
        font-size: 24px;
        font-weight: bold;
        margin-bottom: 10px;
    }

    .text{
        font-size: 16px;
        line-height: 1.6;
        margin-bottom: 30px;
        text-align: center;
    }

    .input-group{
        margin-bottom: 20px;
    }

    input[type="password"]{
        width: 100%;
        padding: 12px;
        border-radius: 6px;
        border: 1px solid #ccc;
        font-size: 16px;
    }

    button{
        width: 100%;
        background-color: #FF7A00;
        color: white;
        padding: 14px;
        border: none;
        border-radius: 6px;
        font-size: 16px;
        cursor: pointer;
    }

    button:hover{
        background-color: #e56d00;
    }

    .footer{
        font-size: 12px;
        color: #777;
        text-align: center;
        margin-top: 30px;
    }
    </style>
</head>
<body>
    
    <div class="container">

        <div class="logo">
            <img src="{{ asset('images/logo-sin-letras.png')}}" alt="logo" width="200">
        </div>

        <div class="title">Restablecer contraseña</div>

        <div class="text">
            Introduce tu nueva contraseña para continuar.
        </div>

        <form method="POST" action="{{ url('/reset-password')}}">
            @csrf

            <input type="hidden" name="token" value="{{$token}}">

            <div class="input-group">
                <input type="password" name="password" placeholder="Nueva contraseña" required>
            </div>

            <div class="input-group">
                <input type="password" name="password_confirmation" placeholder="Confirmar contraseña" required>
            </div>

            <button type="submit">Guardar nueva contraseña</button>
        </form>

        <div class="footer">
            © {{date('Y')}} LiberArte - Arte en Libertad, expresión sin fronteras
        </div>
    </div>

</body>
</html>