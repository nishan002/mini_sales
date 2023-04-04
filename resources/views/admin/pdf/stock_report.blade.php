<!DOCTYPE html>
<html>
<head>
    <style>
        #customers {
            font-family: Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        #customers td, #customers th {
            border: 1px solid #ddd;
            padding: 8px;
        }

        #customers tr:nth-child(even){background-color: #f2f2f2;}

        #customers tr:hover {background-color: #ddd;}

        #customers th {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: left;
            background-color: #04AA6D;
            color: white;
        }
    </style>
</head>
    <body>

        <h1 style="text-align: center">Product Stock Report</h1>

        <table id="customers">
            <thead>
                <tr>
                    <th>Product Name</th>
                    <th>Quantity Sold</th>
                    <th>Current Stock</th>
                    <th>Purchase Price</th>
                    <th>Sales Price</th>
                    <th>Total Current Stock Price</th>
                </tr>
            </thead>
            <tbody>
                @foreach($stock_reports as $product)
                    <tr>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->sales->sum('pivot.quantity') }}</td>
                        <td>{{ $product->quantity }}</td>
                        <td>{{ $product->purchase_price }}</td>
                        <td>{{ $product->sales_price }}</td>
                        <td>{{ number_format($product->quantity * $product->sales_price, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    </body>
</html>


