
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

           <div>
  <!-- Login status -->
    @if(auth()->check())
        <p>You are logged in as {{ auth()->user()->name }}</p>
    @else
        <p>You are not logged in.</p>
    @endif
</div>
    <div>
        <a href="/login-form">Login</a>
        <br>
        <a href="/signup-form">Signup</a>
        <br>
        @if(auth()->check())
       <?php echo '<a href="/change-password-form">Change Password</a>'?>
        @else
        @endif
    </div>
    <form action="/logout" method="POST">
        @csrf
            <button type="submit">Log out</button>
    </form>
</div>

</body>
</html>
