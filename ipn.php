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
    if(isset($payment))
    {
        $_SESSION["notificacion_pay"]=$payment;
        $myfile = fopen("notificacion_pay.txt", $payment);
    }
    if(isset($plan))
    {
        $_SESSION["notificacion_plan"]=$plan;
        $myfile = fopen("notificacion_plan.txt", $plan);
    }
    // echo '<pre>'; 
    // var_dump(isset($payment)?$payment:'');
    // var_dump(isset($plan)?$plan:'');
    // echo'</pre>';
?>