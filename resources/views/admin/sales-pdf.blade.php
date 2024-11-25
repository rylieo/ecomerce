<!DOCTYPE html>
<html>
<head>
    <title>Sales Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        h1, h2, h3 {
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            padding: 8px 12px;
            border: 1px solid #ddd;
        }
        th {
            background-color: #f4f4f4;
        }
    </style>
</head>
<body>
    <h1>Sales Report</h1>

    <h2>Sales by Category</h2>
    <table>
        <thead>
            <tr>
                <th>Category</th>
                <th>Total Orders</th>
            </tr>
        </thead>
        <tbody>
            @foreach($categoryNames as $index => $category)
                <tr>
                    <td>{{ $category }}</td>
                    <td>{{ $orderCounts[$index] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h2>Daily Sales</h2>
    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Total Products Sold</th>
            </tr>
        </thead>
        <tbody>
            @foreach($days as $index => $day)
                <tr>
                    <td>{{ $day }}</td>
                    <td>{{ $dailySoldCounts[$index] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h2>Monthly Sales</h2>
    <table>
        <thead>
            <tr>
                <th>Month</th>
                <th>Total Products Sold</th>
            </tr>
        </thead>
        <tbody>
            @foreach($months as $index => $month)
                <tr>
                    <td>{{ $month }}</td>
                    <td>{{ $monthlySoldCounts[$index] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h2>Yearly Sales</h2>
    <table>
        <thead>
            <tr>
                <th>Year</th>
                <th>Total Products Sold</th>
            </tr>
        </thead>
        <tbody>
            @foreach($years as $index => $year)
                <tr>
                    <td>{{ $year }}</td>
                    <td>{{ $yearlySoldCounts[$index] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
