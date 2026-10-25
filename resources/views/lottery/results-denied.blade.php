<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=8">
    <title>Access Denied</title>
</head>
<body>
    <h3 style="margin: 0 0 10px 0; font-size: 16px; font-weight: bold;">Access Denied</h3>
    <p>{{ $message ?? 'Results are not available for this installation.' }}</p>
    @if (!empty($showPayment))
    <p><img src="/images/gpay.jpg" alt="Google Pay" width="392" height="244" border="0"></p>
    @endif
</body>
</html>
