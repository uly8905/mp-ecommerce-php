<?php
    require_once '../vendor/autoload.php'; 
    $url_bases = explode('/', $_SERVER['REQUEST_URI']);
    $url_base='';
    if(count($url_bases) >2)
    {
        $url_base='/'.$url_bases[1];
    }
    // Agrega credenciales
    MercadoPago\SDK::setAccessToken('APP_USR-8058997674329963-062418-89271e2424bb1955bc05b1d7dd0977a8-592190948');
    MercadoPago\SDK::setPublicKey('APP_USR-158fff95-0bdf-4149-9abc-c8b0ac7f289f');
    MercadoPago\SDK::setIntegratorId('dev_24c65fb163bf11ea96500242ac130004');

    // Crea un objeto de preferencia
    $preference = new MercadoPago\Preference();
    
    # Building an item
    $linkbase='https://usosa-mp-ecommerce-php.herokuapp.com';
    $item1 = new MercadoPago\Item();
    $item1->id = "00001";
    $item1->picture_url=$linkbase.str_replace('./','/',$_POST['img']);
    // $item1->picture_url=(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://".$_SERVER['HTTP_HOST'].$url_base. str_replace('./','/',$_POST['img']);
    $item1->title = $_POST['title']; 
    $item1->quantity = $_POST['unit'];
    $item1->unit_price = $_POST['price'];
    
    $preference->items = [$item1];
    $baseback=(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://".$_SERVER['HTTP_HOST'].$url_base;
    $backUrl=[
        'success'=>$baseback.'/success.php',
        'failure'=>$baseback.'/error.php',
        'pending'=>$baseback.'/pending.php',

    ];
    $payer=[
        'name'=>'Lalo',
        'first_name'=>'Landa',
        'email'=>'test_user_58295862@testuser.com',
        'phone'=>[
            'area_code'=>'52',
            'number'=>'5549737300'
        ],
        'address'=>[
            'street_name'=>' Insurgentes Sur',
            'street_number'=>'1602',
            'zip_code'=>'03940'
            ]
    ];

    $preference->payer=(object)$payer;
    $preference->back_urls=$backUrl;
    $preference->auto_return='all';
    $preference->payment_methods = [
        "excluded_payment_methods" => [
            ["id" => "amex"],["id" => "atm"]
        ],
        "installments" => 6
    ];
    
    $preference->external_reference = "ush.sosa@gmail.com";
    
    $preference->save();
    
    // echo $linkbase.str_replace('./','/',$_POST['img']).'</br>';
    //  echo json_encode(['url'=>$preference->sandbox_init_point]);
    //  exit;
    // echo $preference->sandbox_init_point;
    
    // header("Location: ".$preference->sandbox_init_point);
  ?>
  <!DOCTYPE html>
  <html lang="en">
  <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Document</title>
  </head>
  <body>
    <script
    src="https://www.mercadopago.com.mx/integrations/v1/web-payment-checkout.js"
    data-preference-id="<?php echo $preference->id; ?>">
    </script>
      
  </body>
  </html>
    
  
