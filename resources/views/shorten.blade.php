<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    <form action={{ route('shortUrl') }} method="POST">
        @csrf
        <input type="text" name="url" value="https://example.com/12345">
        <button type="submit">acortar</button>
    </form>
</body>

</html>
