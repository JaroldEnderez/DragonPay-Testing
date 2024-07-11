<!DOCTYPE html>
<html>
<head>
    <title>Payment Form</title>
</head>
<body>
    <form method="POST" action="{{ route('payment.process') }}">
        @csrf
        <label for="txnid">Transaction ID:</label>
        <input type="text" id="txnid" name="txnid" required>
        <br>
        <label for="amount">Amount:</label>
        <input type="number" id="amount" name="amount" step="0.01" required>
        <br>
        <label for="description">Description:</label>
        <input type="text" id="description" name="description" required>
        <br>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
        <br>
        <button type="submit">Pay Now</button>
    </form>
</body>
</html>
