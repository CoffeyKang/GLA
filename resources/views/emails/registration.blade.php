<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Styles -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/css/bootstrap.min.css" integrity="sha384-Smlep5jCw/wG7hdkwQ/Z5nLIefveQRIY9nfy6xoR1uRYBtpZgI6339F5dgvm/e9B"
        crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/js/bootstrap.min.js" integrity="sha384-o+RDsa0aLu++PJvFqy8fFScvbHFLtbvScb8AjopnFD+iEQ7wo/CG0xlczd+2O/em"
        crossorigin="anonymous"></script>
    <title>GLA Inventory Website Admin</title>
    
    <style>
        body{
            margin:auto;
            text-align: center;
            font-family: Arial,sans-serif;
        }
        .body{
            margin: auto;
            text-align: center;
            width: 530px;
        }

        .content{
            text-align: left !important;
            padding: 50px 0;
        }
        

        .footer{
            width:530px;
            padding: 10px 0;
            background-color: #FFE512;
            font-size: 12px;
            text-align: center;
        }
        .hi{
            font-size: 120%;
        }
        
    </style>
</head>
<body>
    
    <table class='body'>
        <tr>
            <td><img src="http://retail.goldenleafautomotive.com/images/emailHeader.jpg" alt=""></td>
        </tr>
        <tr class='content'>
            <td><span class='hi'>Hi {{$user->firstname}},</span><br>
            <p>Your Account {{ $user->email }} has been set up.</p>
            <p>You can always log in to your account to check your order status and update your personal information.</p>
            <p>If you have any questions, please feel free to contact us.</p></td>
        </tr>
        <tr>
            <td class='footer'>70 Zenway Blvd. Unit 2, Woodbridge, ON., L4H 2Y7 CANADA | 905-850-3433<br>
            &copy; {{date("Y")}} Golden Leaf Automotive. All rights reserved.</td>
        </tr>
    </table>
    
</body>
</html>