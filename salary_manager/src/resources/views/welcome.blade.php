<!DOCTYPE html>
<html>
<head>
    <title>Salary Manager</title>
</head>
<body>
    <form action="{{ route('update.result') }}" method="post">
        @csrf
        <label for="day">Day:</label><br>
        <input type="number" name="day" id="day"><br>
        <label for="amount">Amount:</label><br>
        <input type="number" name="amount" id="amount"><br>
        <button type="submit" value="Submit"
        style="margin: 20px 0px 15px 0px;">Submit</button>
    </form>

    <p>*Type "0" for each just to view</p>
</body>
</html>