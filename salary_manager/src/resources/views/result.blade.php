<!DOCTYPE html>
<html lang="ja">
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
    <button type="submit" value="Submit" style="margin: 20px 0 15px 0;">Submit</button>
</form>

<h2>Total Amount : {{ $total_amount }}</h2>

<table border="1">
    <thead>
    <tr>
        <th>Day</th>
        <th>Amount</th>
    </tr>
    </thead>
    <tbody>
    @foreach($amounts as $day)
        <tr>
            <td>{{ $day->day }}</td>
            <td>{{ $day->amount }}</td>
        </tr>
    @endforeach
    </tbody>
</table>

<form action="{{ route('reset.salary.table') }}" method="post">
    @csrf
    <button type="submit" value="Reset" style="margin: 60px 0 0 0;">Reset</button>
</form>
</body>
</html>
