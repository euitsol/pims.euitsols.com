<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Exist value</title>
</head>
<body>
    <section>
        <div>
            <h1>
                <button type="button" onclick="history.back()" style="color: green; align: center;font-size: 22px;">Go back</button>
            </h1>
        </div>
        <div>
            @if(!empty($message))
                <div class="alert alert-success">
                    <h1 style="text-align: center;color:red;">{{ $message }}</h1>
                </div>
            @endif
        </div>


    </section>
</body>
</html>
