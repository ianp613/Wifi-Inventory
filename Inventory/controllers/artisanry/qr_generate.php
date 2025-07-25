<?php
    header('Content-Type: application/json');
    include("../../includes.php");
    use HeroQR\Core\QRCodeGenerator;


    $qr = (new QRCodeGenerator())
    ->setData($_POST["qr_text"])
    ->setColor($_POST["fgColor"])
    ->setBackgroundColor($_POST["bgTransparent"] == "true" ? "#ffffff00" : $_POST["bgColor"])
    ->setSize(800)
    ->setMargin(30)
    ->generate('png', [
        'Size'      => 1024,
        'BlockSize' => 10,         // Crisp modules
        'Shape'  => 'S2', // PATTERN = [S1 => SQUARE, S2 => CIRCLE, S3 => STAR, S4 => DIAMOND, S5 => HEART]
        'Marker' => 'M6', // MARKER BORDER = 
        'Cursor' => 'C3', // MARKER CENTER = 
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


