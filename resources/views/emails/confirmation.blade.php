<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=\, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
   <div><div>Dear {{$name}},</div></br></br>
   <div style='padding-top:8px;'>Please click The following link For verifying and activation of your account</div>
        <div style='padding-top:10px;'><a href='http://localhost:8000/email_verification/{{$activationcode}}'>Click Here</a></div>
        <div style='padding-top:4px;'>Powered by <a href='phpgurukul.com'>phpgurukul.com</a></div></div>
    
</body>
</html>