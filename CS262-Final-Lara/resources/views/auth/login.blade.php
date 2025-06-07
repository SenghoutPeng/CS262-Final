<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>


</head>
<body>
<div>
           @if(session('status'))
           <div class="alert alert-success">
            
            {{ session('status') }}
            
           </div>
           @endif
           </div>
<div class="form-container">

    <form action="/login" method="POST">
        @csrf
       
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" required>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>
        </div>

        <div class="form-group">
            <button type="submit">Log in</button>
        </div>
    </form>
</div>

</body>
</html>