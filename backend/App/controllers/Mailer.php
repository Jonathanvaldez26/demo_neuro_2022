<?php

namespace App\controllers;

defined("APPPATH") or die("Access denied");
require dirname(__DIR__) . '/../public/librerias/PHPMailer/Exception.php';
require dirname(__DIR__) . '/../public/librerias/PHPMailer/PHPMailer.php';
require dirname(__DIR__) . '/../public/librerias/PHPMailer/SMTP.php';

use \Core\MasterDom;
use \Core\Controller;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use \App\models\Vuelos as VuelosDao;


class Mailer
{


    public function mailer($msg)
    {
        $mail = new PHPMailer(true);

        try {
            //Server settings
            $mail->SMTPDebug = 0;                      //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = 'contacto@convencionasofarma2022.mx';                     //SMTP username contacto@convencionasofarma2022.mx
            $mail->Password   = 'lxwqdkznaznpwpcg';                               //SMTP password
            $mail->SMTPSecure = 'ssl';
            $mail->SMTPAutoTLS = false;            //Enable implicit TLS encryption
            $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            //Recipients
            $mail->setFrom($msg['email'], 'MUSA 2022 Asofarma');
            $mail->addAddress($msg['email'], $msg['name']);     //Add a recipient


            $html = '     
    <!DOCTYPE html>
        <html lang="es">

        <!-- Define Charset -->
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

        <!-- Responsive Meta Tag -->
        <meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0;">
        
        <link rel="apple-touch-icon" sizes="76x76" href="../../../assets/img/aso_icon.png">
        <link rel="icon" type="image/vnd.microsoft.icon" href="../../../assets/img/aso_icon.png">

        <title>Email Template</title>

        <!-- Responsive and Valid Styles -->
        <style type="text/css">
            body {
                width: 100%;
                background-color: #FFF;
                margin: 0;
                padding: 0;
                -webkit-font-smoothing: antialiased;
                font-family: arial;
            }

            html {
                width: 100%;
            }
            .container{
                width: 80%;
                padding: 20px;
                margin: 0 auto;
                
            }

            img{
                width: 100%;
            }

            .code-v{
                background: yellow;
            }

        
        </style>

        </head>

        <body leftmargin="0" topmargin="0" marginheight="0" marginwidth="0">
            
            <div class="container">
                <img src="https://registro.foromusa.com/img/musa-01.png" alt="">
                <br>
                <p>
                    Hola <b>'.$msg['name'].'</b>
                </p>
                <br>
                <p>
                Le informamos que su itinerario se encuentra disponible, si desea consultarlo de clic en el siguiente enlace, <a href="https://convencionasofarma2022.mx/">https://convencionasofarma2022.mx/</a>, ingrese su correo electrónico y su contraseña, diríjase a itinerarios, de clic en ITINERARIO y visualice si sus datos son correctos, si usted detecta un error, comuníquese a la línea de soporte a través de WhatsApp en el siguiente enlace.<br>
                <a href="https://api.whatsapp.com/send?phone=52558010%204181&text=Buen%20d%C3%ADa">https://api.whatsapp.com/send?phone=52558010%204181&text=Buen%20d%C3%ADa<a/> 
                </p>
                <br>
                <p>
                Recuerde que sus pases de abordar estarán disponibles hasta 48 horas de anticipación al vuelo, debe tener cargado y validado con éxito su comprobante de vacunación y su prueba SARS-CoV-2 con un lapso no mayor a 48 horas del vuelo.
                </p>
                <img src="https://registro.foromusa.com/img/musa-01.png" alt="firma">

                    
                
            </div>
            
                
        </body>

</html>';


            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = 'AVISO, ITINERARIO DISPONIBLE PARA CONSULTA.';
            $mail->Body    = $html;
            $mail->CharSet = 'UTF-8';

            $mail->send();
           //echo 'El mensaje ha sido enviado';
        } catch (Exception $e) {
           //echo "No se pudo enviar el email: {$mail->ErrorInfo}";
        }
    }


    public function mailVuelos($msg) {
        $mail = new PHPMailer(true);

        try {
            //Server settings
            $mail->SMTPDebug = 0;                      //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = 'contacto@convencionasofarma2022.mx';                     //SMTP username contacto@convencionasofarma2022.mx
            $mail->Password   = 'lxwqdkznaznpwpcg';                               //SMTP password
            $mail->SMTPSecure = 'ssl';
            $mail->SMTPAutoTLS = false;            //Enable implicit TLS encryption
            $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            //Recipients
            $mail->setFrom($msg['email'], 'MUSA 2022 Asofarma');
            $mail->addAddress($msg['email'], $msg['name']);     //Add a recipient


            $html = '     
    <!DOCTYPE html>
        <html lang="es">

        <!-- Define Charset -->
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

        <!-- Responsive Meta Tag -->
        <meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0;">
        
        <link rel="apple-touch-icon" sizes="76x76" href="../../../assets/img/aso_icon.png">
        <link rel="icon" type="image/vnd.microsoft.icon" href="../../../assets/img/aso_icon.png">

        <title>Email Template</title>

        <!-- Responsive and Valid Styles -->
        <style type="text/css">
            body {
                width: 100%;
                background-color: #FFF;
                margin: 0;
                padding: 0;
                -webkit-font-smoothing: antialiased;
                font-family: arial;
            }

            html {
                width: 100%;
            }
            .container{
                width: 80%;
                padding: 20px;
                margin: 0 auto;
                
            }

            img{
                width: 100%;
            }

            .code-v{
                background: yellow;
            }

        
        </style>

        </head>

        <body leftmargin="0" topmargin="0" marginheight="0" marginwidth="0">
            
            <div class="container">
                <img src="https://registro.foromusa.com/img/musa-01.png" alt="">
                <br>
                <p>
                    Hola <b>'.$msg['name'].'</b>
                </p>
                <br>
                <p style="text-align: justify;">
                    Le informamos que sus pases de abordar rumbo a la MUSA 2022, fueron cargados con éxito, usted puede consultarlos en su app móvil en la sección de Pases de Abordar que ya se encuentra activa o a través del siguiente link para consulta automática
                    <br> <br><a href="'.$msg['url'].'"></a>'.$msg['url'].'<br> <br>
                    Si usted necesita ayuda, comuníquese a la línea de soporte a través de WhatsApp en el siguiente enlace 
                    <br>
                    <br><a href="shorturl.at/afsuQ">shorturl.at/afsuQ<a/>
                </p>
                <p>
                    
                </p>
                <br>
                <img src="https://registro.foromusa.com/img/musa-01.png" alt="firma">

                    
                
            </div>
            
                
        </body>

</html>';


            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = 'PASE DE ABORDAR RUMBO A LA MUSA.';
            $mail->Body    = $html;
            $mail->CharSet = 'UTF-8';

            $mail->send();
           //echo 'El mensaje ha sido enviado';
        } catch (Exception $e) {
           //echo "No se pudo enviar el email: {$mail->ErrorInfo}";
        }
    }

    public function mailVuelosRegreso($msg) {
        $mail = new PHPMailer(true);

        try {
            //Server settings
            $mail->SMTPDebug = 0;                      //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = 'contacto@convencionasofarma2022.mx';                     //SMTP username contacto@convencionasofarma2022.mx
            $mail->Password   = 'lxwqdkznaznpwpcg';                               //SMTP password
            $mail->SMTPSecure = 'ssl';
            $mail->SMTPAutoTLS = false;            //Enable implicit TLS encryption
            $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            //Recipients
            $mail->setFrom($msg['email'], 'MUSA 2022 Asofarma');
            $mail->addAddress($msg['email'], $msg['name']);     //Add a recipient


            $html = '     
    <!DOCTYPE html>
        <html lang="es">

        <!-- Define Charset -->
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

        <!-- Responsive Meta Tag -->
        <meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0;">
        
        <link rel="apple-touch-icon" sizes="76x76" href="../../../assets/img/aso_icon.png">
        <link rel="icon" type="image/vnd.microsoft.icon" href="../../../assets/img/aso_icon.png">

        <title>Email Template</title>

        <!-- Responsive and Valid Styles -->
        <style type="text/css">
            body {
                width: 100%;
                background-color: #FFF;
                margin: 0;
                padding: 0;
                -webkit-font-smoothing: antialiased;
                font-family: arial;
            }

            html {
                width: 100%;
            }
            .container{
                width: 80%;
                padding: 20px;
                margin: 0 auto;
                
            }

            img{
                width: 100%;
            }

            .code-v{
                background: yellow;
            }

        
        </style>

        </head>

        <body leftmargin="0" topmargin="0" marginheight="0" marginwidth="0">
            
            <div class="container">
                <img src="https://registro.foromusa.com/img/musa-01.png" alt="">
                <br>
                <p>
                    Hola <b>'.$msg['name'].'</b>
                </p>
                <br>
                <p style="text-align: justify;">
                    Le informamos que sus pases de abordar de regreso a casa, fueron cargados con éxito, usted puede consultarlos en su app móvil en la sección de Pases de Abordar que ya se encuentra activa o a través del siguiente link para consulta automática
                    <br> <br><a href="'.$msg['url'].'"></a>'.$msg['url'].'<br> <br>
                    Si usted necesita ayuda, comuníquese a la línea de soporte a través de WhatsApp en el siguiente enlace 
                    <br>
                    <br><a href="shorturl.at/afsuQ">shorturl.at/afsuQ<a/>
                </p>
                <p>
                    
                </p>
                <br>
                <img src="https://registro.foromusa.com/img/musa-01.png" alt="firma">

                    
                
            </div>
            
                
        </body>

</html>';


            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = 'PASE DE ABORDAR REGRESO A CASA.';
            $mail->Body    = $html;
            $mail->CharSet = 'UTF-8';

            $mail->send();
           //echo 'El mensaje ha sido enviado';
        } catch (Exception $e) {
           //echo "No se pudo enviar el email: {$mail->ErrorInfo}";
        }
    }

    public function mailVuelosAdmin() {

        $id_pase_abordar = $_POST['id_pase_abordar'];
        $titulo_pase = '';
        $link = '';
        // echo $id_pase_abordar;
        $pase = VuelosDao::getPaseById($id_pase_abordar)[0];

        if($pase['tipo'] == 1){
            $titulo_pase = 'PASE DE ABORDAR RUMBO MUSA.';
            $link = 'comprobante_vuelo_uno/'.$pase['link'];
            // $link = 'comprobante_vuelo_uno/'.$pase['link'];
        }else{
            $titulo_pase = 'PASE DE ABORDAR REGRESO A CASA.';
            $link = 'comprobante_vuelo_dos/'.$pase['link'];            
            // $link = 'comprobante_vuelo_dos/'.$pase['link'];
        }

        $mail = new PHPMailer(true);

        try {
            //Server settings
            $mail->SMTPDebug = 0;                      //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = 'contacto@convencionasofarma2022.mx';                     //SMTP username contacto@convencionasofarma2022.mx
            $mail->Password   = 'lxwqdkznaznpwpcg';                               //SMTP password
            $mail->SMTPSecure = 'ssl';
            $mail->SMTPAutoTLS = false;            //Enable implicit TLS encryption
            $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            //Recipients
            $mail->setFrom($pase['email'], 'MUSA 2022');
            $mail->addAddress($pase['email'], $pase['nombre']);     //Add a recipient


            $html = '     
    <!DOCTYPE html>
        <html lang="es">

        <!-- Define Charset -->
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

        <!-- Responsive Meta Tag -->
        <meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0;">
        
        <link rel="apple-touch-icon" sizes="76x76" href="../../../assets/img/aso_icon.png">
        <link rel="icon" type="image/vnd.microsoft.icon" href="../../../assets/img/aso_icon.png">

        <title>Email Template</title>

        <!-- Responsive and Valid Styles -->
        <style type="text/css">
            body {
                width: 100%;
                background-color: #FFF;
                margin: 0;
                padding: 0;
                -webkit-font-smoothing: antialiased;
                font-family: arial;
            }

            html {
                width: 100%;
            }
            .container{
                width: 80%;
                padding: 20px;
                margin: 0 auto;
                
            }

            img{
                width: 100%;
            }

            .code-v{
                background: yellow;
            }

        
        </style>

        </head>

        <body leftmargin="0" topmargin="0" marginheight="0" marginwidth="0">
            
            <div class="container">
                <img src="https://registro.foromusa.com/img/musa-01.png" alt="">
                <br>
                <p>
                    Hola <b>'.$pase['nombre'].'</b>
                </p>
                <br>
                <p style="text-align: justify;">
                    Le informamos que sus pases de abordar rumbo a la MUSA 2022, fueron cargados con éxito, usted puede consultarlos en su app móvil en la sección de Pases de Abordar que ya se encuentra activa o a través del siguiente link para consulta automática
                    <br> <br><a href="https://admin.foromusa.com/'.$link.'">https://admin.foromusa.com/'.$link.'</a><br> <br>
                    Si usted necesita ayuda, comuníquese a la línea de soporte a través de WhatsApp en el siguiente enlace 
                    <br>
                    <br><a href="https://wa.link/t8evgh">https://wa.link/t8evgh<a/>
                </p>
                <p>
                    
                </p>
                <br>
                <img src="https://registro.foromusa.com/img/musa-01.png" alt="firma">

                    
                
            </div>
            
                
        </body>

</html>';


            //Content
            $mail->isHTML(true);
            $mail->AddAttachment($link);                                  //Set email format to HTML
            $mail->Subject = $titulo_pase;
            $mail->Body    = $html;
            $mail->CharSet = 'UTF-8';

            $mail->send();
           

           VuelosDao::updateEmail($id_pase_abordar);
           echo 'success';
           //echo 'El mensaje ha sido enviado';
        } catch (Exception $e) {
            echo 'fail';
           //echo "No se pudo enviar el email: {$mail->ErrorInfo}";
        }
    }



}


// Le informamos que su itinerario se encuentra disponible, si desea consultarlo de clic en el siguiente enlace, <a href="https://convencionasofarma2022.mx/">https://convencionasofarma2022.mx/</a>, ingrese su correo electrónico y su contraseña, diríjase a itinerarios, de clic en ITINERARIO y visualice si sus datos son correctos, si usted detecta un error, comuníquese a la línea de soporte a través de WhatsApp en el siguiente enlace.<br>
//     <a href="https://api.whatsapp.com/send?phone=52558010%204181&text=Buen%20d%C3%ADa">https://api.whatsapp.com/send?phone=52558010%204181&text=Buen%20d%C3%ADa<a/> 