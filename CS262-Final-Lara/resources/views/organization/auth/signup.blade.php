<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Your Organization</title>
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
    <h2>Register Your Organization</h2>
    <p>Create an account to access our platform</p>

    <form action="/organization/signup" method="POST">
        @csrf

        <fieldset>
            <legend>Organization Details</legend>

            <div class="form-group">
                <label for="org_name">Organization Name</label>
                <input type="text" id="org_name" name="org_name" required>
            </div>

            <div class="form-group">
                <label for="org_type">Organization Type*</label>
                <select id="org_type" name="org_type" required>
                    <option value="">Select type</option>
                    <option value="ngo">NGO</option>
                    <option value="company">Company</option>
                    <option value="school">School</option>
                    <!-- Add more types as needed -->
                </select>
            </div>

            <div class="form-group">
                <label for="email">Email Address*</label>
                <input type="email" id="email" name="email" required>
            </div>

            <div class="form-group">
                <label for="password">Password*</label>
                <input type="password" id="password" name="password" required>
                <small>Must be at least 8 characters with letters and numbers</small>
            </div>

            <div class="form-group">
                <label for="password_confirmation">Confirm Password*</label>
                <input type="password" id="password_confirmation" name="password_confirmation" required>
            </div>
        </fieldset>

        <fieldset>
            <legend>Primary Contact Person</legend>

            <div class="form-group">
                <label for="contact_name">Contact Name*</label>
                <input type="text" id="contact_name" name="contact_name" required>
            </div>

            <div class="form-group">
                <label for="contact_phone">Contact Phone*</label>
                <input type="text" id="contact_phone" name="contact_phone" required>
            </div>

            <div class="form-group">
                <label for="contact_email">Contact Email*</label>
                <input type="email" id="contact_email" name="contact_email" required>
            </div>
        </fieldset>


        <div class="form-group">
            <button type="submit">Create Organization Account</button>
        </div>

    </form>
</div>

</body>
</html>
