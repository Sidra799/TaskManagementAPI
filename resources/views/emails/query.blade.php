<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<div><div>Dear {{$data['toName']}},</div></br></br>
      <div style='padding-top:8px;'>Task Title: {{$data['taskTitle']}} </div> </br></br>
      <div style='padding-top:8px;'>Query: {{$data['query']}} </div></br></br>

      <div style='padding-top:8px;'>Please click The following link to Check the Task</div>
      <div style='padding-top:10px;'><a href="http://localhost:8000/editTask/{{$data['taskId']}}">Click Here</a></div>
      <div style='padding-top:4px;'>Powered by <a href='http://localhost:8000/login'>pnp.com</a></div></div>
      


</body>
</html>