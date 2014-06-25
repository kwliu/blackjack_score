<?php

//initialise variables
$return = array();
$has_error = false;
$card_score_detail = array();
$cards = array();


// format input string
$cards[]  =  format_str(trim($_POST['card1']));
$cards[]  =  format_str(trim($_POST['card2']));

if((!empty($cards[0]) || !empty($cards[1])) && ($cards[0] == $cards[1]))
{
    $result  = array('status'=>'fail', 'score'=>'null','err_msg'=>'Duplicated input detected');
    $return = array('has_error'=>true, 'card1' => $result, 'card2' => $result);
}else
{
    for($i=0; $i < sizeof($cards); $i++)
    {
        if(($score = get_blackjack_score($cards[$i])) !== false)
        {
            $card_score= array('status'=>'pass', 'score'=>$score);
        }
        else
        {
            $has_error = true;
            $card_score= array('status'=>'fail', 'score'=>'null','err_msg' => (empty($cards[$i])?'No card detcted':'Invalid card input'));
        }    
        
        $card_score_detail[] = $card_score;
    }
    
    $return = array('has_error'=>$has_error, 'card1' => $card_score_detail[0],'card2' => $card_score_detail[1]);
    
}
    
echo json_encode($return);
    

/*
 * format input string by removing leading zeros and covert all charachters to upper case
 * @param string $card_str string to be formmated
 * 
 * @return string formatted string
 */


function format_str($card_str)
{
    return strtoupper(preg_replace('/^[0]+/','',strtoupper($card_str)));
}



/*
 * check if its a valid card input 
 * @param string $card card to be checked
 * @return boolan TRUE if valid else FALSE
 */
function is_valid_card($card)
{
    $pattern = '/^([0]?[2-9]|10|[A|K|Q|J]{1})[S|C|D|H]{1}$/i';
    
    return preg_match($pattern, $card);
}

/*
 * get the blackjack of the card
 * @param string $card Card input
 * @return int Blackjack score of the entered, FALSE if invalid card detected
 */

function get_blackjack_score($card)
{
    
    $card = strtoupper(preg_replace('/^[0]+/','',strtoupper($card))); // remove leading zero and covert string to upper case
    
    // check if its a valid card input
    if(is_valid_card($card))
    {
        if(strlen($card) == 2)
        {
            return (int) (is_numeric(substr($card,0,1))?substr($card,0,1):((substr($card,0,1) == 'A')?11:10));
        }elseif(strlen($card) === 3 )
        {
            return (is_numeric(substr($card,0,2))? (int) substr($card,0,2):false);
        }
    }
    else
    {
        return false;
    }
}
?>