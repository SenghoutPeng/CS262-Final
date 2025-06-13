
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
    @if(auth('organization')->check() )
        <p>You are logged in as {{ auth('organization')->user()->org_name}}</p>
    @else
        <p>You are not logged in.</p>
    @endif
</div>
    <div>
        <a href="/organization/login-form">Login</a>
        <br>
        <a href="/organization/signup-form">Signup</a>
        <br>
        @if(auth('organization')->check())
       <?php echo '<a href="/organization/change-password-form">Change Password</a>'?>
        @else
        @endif
    </div>
    <form action="/organization/logout" method="POST">
        @csrf
            <button type="submit">Log out</button>
    </form>
    @else
        @endif
</div>

</body>
</html>
