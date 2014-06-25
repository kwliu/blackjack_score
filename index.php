<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title>Blackjack score appplication</title>
        <script src="js/jquery-2.1.1.min.js"></script>
        <script type="text/javascript">
            $(document).ready(function(){
                
                $('.detail').hide();
                
                $('#get_score_btn').click(function()
                {   
                    $.ajax({
                        type: 'POST',
                        url: 'action_get_score.php',
                        dataType : 'json',
                        data:{card1: $('#card1').val(), card2: $('#card2').val()},
                        success: function(data){
                            var score1,score2;
                            
                            score1 = data.card1.score;
                            score2 = data.card2.score;
                            
                            if (data.card1.status != 'fail') {
                                $('#card1_detail').text(score1);
                                $('#error_msg1').text('');
                            }else {
                                $('#error_msg1').text(data.card1.err_msg);
                            }
                            
                            if (data.card2.status != 'fail') {
                                $('#card2_detail').text(score2);
                                $('#error_msg2').text('');
                            }else {
                                $('#error_msg2').text(data.card2.err_msg);
                            }
                            
                            if (data.has_error == true) {
                                $('.detail').hide();
                            }
                            else
                            {
                                $('#total').text((score1+score2));
                                $('.detail').show();
                            }
                        }
                    })
                })
            });
        </script>
    </head>
    <style type="text/css">
        input {
            text-align: center;
            margin: 5px auto;
        }
        
        .card_input {
            border: solid;
            border-width: 1px;
            border-radius: 5px;
            padding: 5px;
            max-width: 600px;
        }
        .detail {
            display: none;
            border: solid;
            border-width: 1px;
            border-radius: 5px;
            padding: 5px 10px;
            
            
        }
        .score {
            color: red;
            font-weight: bold;
            margin: 5px;
            
        }
        
        .err_msg {
            color: red;
            margin-left: 5px;
        }
        
    </style>
    <body>
        <div class="card_input">
            
            <h2>Please enter card details</h2>
            Card 1 : <input type="text" id="card1" name="card1" maxlength="3" size="3" autocomplete=off><span id="error_msg1" class="err_msg"></span></br>
            Card 2 : <input type="text" id="card2" name="card2" maxlength="3" size="3" autocomplete=off><span id="error_msg2" class="err_msg"></span></br>
            <div style="text-align: center"><input type="submit" value="Get Score" id="get_score_btn"></div>
            
        </div>
        <hr>
        <div class="detail">
            Card 1 Score: <span id="card1_detail" class="score"></span></br>
            Card 2 Score: <span id="card2_detail" class="score"></span></br>
            Total score:<span id="total" class="score"></span>
        </div>
    </body>
</html>