<!DOCTYPE html>
<html>
<head>
    <title>Emergency Blood Request</title>
</head>
<body>

    <h1>Emergency Blood Request</h1>

    <p>
        <strong>Patient Name:</strong>
        {{ $requestData['patient_name'] }}
    </p>

    <p>
        <strong>Blood Group:</strong>
        {{ $requestData['blood_group'] }}
    </p>

    <p>
        <strong>Hospital:</strong>
        {{ $requestData['hospital'] }}
    </p>

    <p>
        <strong>City:</strong>
        {{ $requestData['city'] }}
    </p>

    <p>
        <strong>Phone:</strong>
        {{ $requestData['phone'] }}
    </p>

    <p>
        <strong>Message:</strong>
        {{ $requestData['message'] }}
    </p>

</body>
</html>