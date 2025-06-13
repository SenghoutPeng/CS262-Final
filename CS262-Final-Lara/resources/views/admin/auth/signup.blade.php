<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup</title>


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
    <form action="/admin/signup" method="POST">
        @csrf
        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" required>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>
        </div>
        <div class="form-group">
            <label for="password_confirmation">Confirm Password</label>
            <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Comfirm Password" required>
        </div>

        <div class="form-group">
            <button type="submit">Create Account</button>
        </div>
    </form>
</div>

</body>
</html>
