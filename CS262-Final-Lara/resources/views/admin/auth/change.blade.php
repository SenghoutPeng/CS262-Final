<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>


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
    <form action="/admin/change-password" method="POST">
        @csrf

        <div class="form-group">
            <label for="current_password">Old Password</label>
            <input type="password" id="current_password" name="current_password" required>
        </div>
        <div class="form-group">
            <label for="password">New Password</label>
            <input type="password" id="password" name="password" required>
        </div>
        <div class="form-group">
            <label for="password_confirmation">Confirm Password</label>
            <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Comfirm Password" required>
        </div>

        <div class="form-group">
            <button type="submit">Change Password</button>
            <a href="/">Home</a>
        </div>
    </form>
</div>

</body>
</html>
