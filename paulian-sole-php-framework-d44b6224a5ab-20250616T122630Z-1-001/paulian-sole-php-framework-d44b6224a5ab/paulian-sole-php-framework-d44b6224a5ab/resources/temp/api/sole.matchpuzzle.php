<?php
    # Shuffle first set of cards
    $card_temp = explode(",",$_POST["cards"]);
    $card_index = count($card_temp);
    $card = [];
    for ($i=0; $i < $card_index; $i++) { 
        array_push($card,array_splice($card_temp,rand(0,count($card_temp)-1),1)[0]);
    }
    # Shuffle second set of cards and combined it to the first set
    $card_temp = explode(",",$_POST["cards"]);
    $card_index = count($card_temp);
    for ($i=0; $i < $card_index; $i++) { 
        array_push($card,array_splice($card_temp,rand(0,count($card_temp)-1),1)[0]);
    }
    # if card has an empty set
    if(!$card[0]){
        $card = [];
    }
    # Return final set of cards
    print_r(json_encode($card));
?>