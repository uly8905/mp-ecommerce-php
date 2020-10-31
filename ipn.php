<?php
require_once 'vendor/autoload.php'; 
MercadoPago\SDK::setAccessToken('APP_USR-1159009372558727-072921-8d0b9980c7494985a5abd19fbe921a3d-617633181');

switch($_POST["type"]) {
    case "payment":
        $payment = MercadoPago\Payment.find_by_id($_POST["id"]);
        break;
    case "plan":
        $plan = MercadoPago\Plan.find_by_id($_POST["id"]);
        break;
    case "subscription":
        $plan = MercadoPago\Subscription.find_by_id($_POST["id"]);
        break;
    case "invoice":
        $plan = MercadoPago\Invoice.find_by_id($_POST["id"]);
        break;
}
    session_start();
    $msg="";
    if(isset($payment))
    {
        $_SESSION["notificacion_pay"]=$payment;
        $msg = $payment;
    }
    if(isset($plan))
    {
        $_SESSION["notificacion_plan"]=$plan;
        $msg = $plan;
    }

    $transport = (new \Swift_SmtpTransport('smtp.gmail.com', 465, 'SSL'))
        ->setUsername('ush.sosa@gmail.com')
        ->setPassword('mpdnqwwxuxggzuxq')
        ;

        // Create the Mailer using your created Transport
        $mailer = new \Swift_Mailer($transport);

        // Create a message
        $post=json_encode($_POST);
        $message = (new \Swift_Message('notificacion mercadopago'))
        ->setFrom(['ush.sosa@gmail.com'=>'Ulises Sosa'])
        ->setTo('ush.sosa@gmail.com')
        ->setBody($msg.$post,'text/html');

        // Send the message
        $result = $mailer->send($message);
    // echo '<pre>'; 
    // var_dump(isset($payment)?$payment:'');
    // var_dump(isset($plan)?$plan:'');
    // echo'</pre>';
?>