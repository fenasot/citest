<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>


    <table id="t1" border="1" width="640">

        <thead>
            <caption>出勤表</caption>
            <tr>

                <th width="25%">標題一</th>
                <th width="25%">標題二</th>
                <th width="25%">標題三</th>
                <th width="25%">標題四</th>

            </tr>

        </thead>

        <tbody>

            <tr>
                <td><?php $i = 0;
                    for ($i = 0; $i < 100; $i++) {
                        if ($i % 10 == 0) {
                            if ($i != 0) {
                                echo "<br>";
                            }
                            $u = ($i + 10) / 10;
                            echo "第" . $u . "輪";
                        }
                        echo "#";
                    };


                    ?></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>

            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>

            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>


    </table>

</body>

</html>