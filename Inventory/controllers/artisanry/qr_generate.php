<?php
    header('Content-Type: application/json');
    include("../../includes.php");
    use HeroQR\Core\QRCodeGenerator;


    $qr = (new QRCodeGenerator())
    ->setData($_POST["qr_text"])
    ->setColor('#490a0a')
    ->setBackgroundColor('#ffffff')
    ->setSize(800)
    ->generate('png', [
        'Shape'  => 'S2', // Circle
        'Marker' => 'M2', // Circular finder pattern
        'Cursor' => 'C2', // Circular alignment
    ]);
$qr->saveTo('custom-qr.png');

    $response = [
        "status" => true,
        "type" => "info",
        "size" => null,
        "message" => "QR Created successfully",
        // "image" => $svg,
        "color" => $_POST["qr_color"]
    ];

    echo json_encode($response);


    

    // $overlay = $_POST['overlay'];

    // if(isset($_FILES['logo'])){
    //     $logo = $_FILES['logo'];
    // }


