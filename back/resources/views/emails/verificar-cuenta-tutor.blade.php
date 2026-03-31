<!--Email corporativo-->

<table width="100%" cellpadding="0" style="background-color:#f5f5f5; padding:40px 0;">
    <tr>
        <td align="center">
            <table width="600" cellpadding="0" cellspacing="0" style="background:white; border-radius:8px; padding:40px; font-family: 'Montserrat', Arial, Helvetica, sans-serif; color:#333;">

                <!--Logo-->
                <tr>
                    <td align="center" style="padding-bottom: 20px;">
                        <img src="{{asset('images/logo-sin-letras.png')}}" alt="LiberArte" width="250" style="display:block;">
                    </td>
                </tr>

                <!--Título-->
                <tr>
                    <td align="center" style="font-size: 24px; font-weight:bold; padding-bottom: 10px;" >
                        Verifica tu cuenta
                    </td>
                </tr>

                <!--Texto-->
                <tr>
                    <td style="font-size: 16px; line-height:1.6; padding-bottom: 30px;">
                        Gracias por registrarte en nuestro centro <strong>LiberArte</strong>.
                        Para activar tu cuenta y poder empezar a disfrutar de nuestras actividades pulse el siguiente botón.
                    </td>
                </tr>

                <!--Botón-->
                <tr>
                    <td align="center" style="padding-bottom: 30px;">
                        <a href="{{$url}}"
                            style="background-color:#FF7A00; color:white; padding: 14px 28px;
                                   text-decoration:none; border-radius:6px; font-size: 16px;">
                            Verificar mi cuenta
                        </a>
                    </td>
                </tr>

                <!--Pie de página-->
                <tr>
                    <td style="font-size: 12px; color: #777; text-align:center;">
                        © {{date ('Y')}} LiberArte - Arte en Libertad, expresión sin fronteras
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
