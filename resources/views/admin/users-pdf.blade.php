<!DOCTYPE html>
<html>
<head>

    <title>Donors PDF</title>

    <style>

        body {
            font-family: Arial;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid black;
            padding: 10px;
            text-align: left;
        }

        th {
            background: #eee;
        }

    </style>

</head>

<body>

    <h1>E-Blood Donors List</h1>

    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Blood Group</th>
                <th>City</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->phone }}</td>
                <td>{{ $user->blood_group }}</td>
                <td>{{ $user->city }}</td>
                <td>{{ $user->available }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>