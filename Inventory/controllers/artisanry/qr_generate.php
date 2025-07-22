<?php
    header('Content-Type: application/json');
    include("../../includes.php");
    use HeroQR\Core\QRCodeGenerator;


    $qr = (new QRCodeGenerator())
    ->setData($_POST["qr_text"])
    ->setColor($_POST["fgColor"])
    ->setBackgroundColor($_POST["bgColor"]."00")
    ->setSize(800)
    ->setMargin(30)
    ->generate('png', [
        'Shape'  => 'S2', // Circle
        'Marker' => 'M2', // Circular finder pattern
        'Cursor' => 'C2', // CENTER DOT
    ]);

    // SAVE AS FILE
    // $qr_file = "../../assets/img/qr/". uniqid() . ".png";
    // $qr->saveTo($qr_file);

    // GET IMAGE DATA AS BINARY AND ENCODE IT TO BASE64
    $qr_data = $qr->getDataUri();

    $response = [
        "status" => true,
        "type" => "info",
        "size" => null,
        "message" => "QR Created successfully",
        "qr_data" => $qr_data,
        // "qr_file" => $qr_file
    ];

    echo json_encode($response);


    

    // $overlay = $_POST['overlay'];

    // if(isset($_FILES['logo'])){
    //     $logo = $_FILES['logo'];
    // }


