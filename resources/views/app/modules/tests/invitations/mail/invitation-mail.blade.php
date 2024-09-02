<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Invitation</title>
    <style>
  
        body, h1, p {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }
        h1 {
            font-size: 28px;
            color: #333;
            margin-bottom: 15px;
            text-align: center;
        }
        p {
            font-size: 18px;
            color: #666;
            margin-bottom: 10px;
        }
        span {
            color: black; 
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f9f9f9;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .highlight {
            background-color: #e0f2f1;
            padding: 10px;
            border-radius: 5px;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #4caf50;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            text-align: center;
            margin-top: 15px;
            font-size: 16px
        }
        .btn:hover {
            background-color: #45a049;
        }
        .btn_container{
            display: flex;
            align-items: center;
            justify-content: center
        }
        .btn_container button {
            border: none;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Test Invitation</h1>
        <p>You are invited to participate in the test <span>"{{ $test->title }}"</span> .</p>
        <p class="highlight">Test Description: <span>{{ $test->description }}</span> </p>
        <p>Test Duration: <span>{{ $test->duration }} minutes</span> </p>
        <p>Test Passing Score: <span>{{ $test->passing_score }} points</span> </p>
        <p>Test Session Start At: <span>{{ $testSession->start_at }}</span> </p>
        <p>Test Session End At: <span>{{ $testSession->end_at }}</span></p>
        <p>Test Access code:<span>{{ $testInvitation->access_code }}</span> </p>
        <div class="btn_container">
            <button form="update-form" class="btn">Accept invitation</button>
        </div>
    </div>
  
    <form  id="update-form" action="{{ route('accept_invitation.update', ['testInvitation' => $testInvitation->id]) }}" method="POST" target="_blank" style="display: none;">
        @csrf
        @method('PUT')
        
    </form>
    
</body>
</html>

