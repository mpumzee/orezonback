<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Success</title>
</head>
<body>
    <div class="container">
        <div class="alert alert-success">
            <h4>{{ $message }}</h4>
            <p>You can now <a href="{{ url('/login') }}">login</a>.</p>
        </div>
    </div>
</body>
</html>