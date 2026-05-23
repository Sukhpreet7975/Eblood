<!DOCTYPE html>
<html>
<head>
    <title>Emergency Blood Request</title>
</head>
<body>

    <h1>Emergency Blood Request</h1>

    <p>
        <strong>Patient Name:</strong>
        <?php echo e($requestData['patient_name']); ?>

    </p>

    <p>
        <strong>Blood Group:</strong>
        <?php echo e($requestData['blood_group']); ?>

    </p>

    <p>
        <strong>Hospital:</strong>
        <?php echo e($requestData['hospital']); ?>

    </p>

    <p>
        <strong>City:</strong>
        <?php echo e($requestData['city']); ?>

    </p>

    <p>
        <strong>Phone:</strong>
        <?php echo e($requestData['phone']); ?>

    </p>

    <p>
        <strong>Message:</strong>
        <?php echo e($requestData['message']); ?>

    </p>

</body>
</html><?php /**PATH C:\xampp\htdocs\MyProject\eblood\resources\views\emails\emergency-request.blade.php ENDPATH**/ ?>