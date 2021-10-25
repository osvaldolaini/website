<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
 <head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <title>{{$email->title}}</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
</head>
    <body style="margin: 0; padding: 0;">
        <table align="center" cellpadding="0" cellspacing="0" width="600" style="border-collapse: collapse;">
            <tr>
                <td align="center" bgcolor="#007bff" style="padding: 20px 0 20px 0;">
                    <img width="10%" src="{{url('storage/images/logos/logo.png')}}" alt="Feliz aniversário."  style="display: block;" />
                    <h4 style="margin: 0; padding: 0; font-family:arial; color:#fff;" >{{$config->title}}</h4>
                </td>
            </tr>
            <tr>
                <td bgcolor="#ffffff" style="padding: 40px 30px 40px 30px;">
                    <table cellpadding="0" cellspacing="0" width="100%">
                            <tr>
                                <td width="260" valign="top">
                                    <table cellpadding="0" cellspacing="0" width="100%">
                                        <tr>
                                            <td style="padding: 10px 0 0 0; font-family:arial;">

                                               {!!$email->answer!!}
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                       </table>
                   </td>
            </tr>
            <tr>
                <td bgcolor="#007bff" style="padding: 20px 30px 20px 30px;">
                    <table cellpadding="0" cellspacing="0" width="100%">
                        <tr>
                            <td width="75%">
                                &nbsp;
                            </td>
                            <td align="right">
                                <table border="0" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <!--<td>
                                            <a href="https://www.instagram.com/cssgapa" target="_BLANK">
                                                <img src="{{url('storage/images/email/instagram-1.png')}}" alt="Instagram" width="38" height="38" style="display: block;" border="0" />
                                            </a>
                                        </td>
                                        <td style="font-size: 0; line-height: 0;" width="20">&nbsp;</td>
                                        <td>
                                            <a href="http://www.facebook.com/cssgapaoficial" target="_BLANK">
                                                <img src="{{url('storage/images/email/facebook-1.png')}}" alt="Facebook" width="38" height="38" style="display: block;" border="0" />
                                            </a>
                                        </td>-->
                                        <td style="font-size: 0; line-height: 0;" width="20">&nbsp;</td>
                                        <td>
                                            <a href="http://www.osvaldolaini.com.br" target="_BLANK">
                                                <img src="{{url('storage/images/email/domain.png')}}" alt="dominio" width="38" height="38" style="display: block;" border="0" />
                                            </a>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
       </table>
   </body>
</html>

