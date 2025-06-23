<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Request</title>


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

    <form action="/organization/event-request" method="POST">
        @csrf

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>
        </div>
        <select name="event_category_id" required>
            <option value="">--Select Category</option>
            @foreach($categories as $category)
            <option value="{{$category->event_category_id}}">{{category->event_category_name}}</option>
            @endforeach
        </select>
        <div class="form-group">
            <button type="submit">Log in</button>
        </div>
    </form>
</div>

</body>
</html>
