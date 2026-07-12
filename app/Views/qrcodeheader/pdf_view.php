<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TEST</title>
    <style>
    #table {
        font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
        border-collapse: collapse;
        width: 100%;
    }

    #table td,
    #table th {
        border: 0px solid #ddd;
        padding: 8px;
    }

    #table tr:nth-child(even) {
        /* background-color: #f2f2f2; */
    }

    /* #table tr:hover {
        background-color: #ddd;
    } */

    #table th {
        padding-top: 10px;
        padding-bottom: 10px;
        text-align: left;
        /* background-color: #f2f2f2; */
        color: white;
    }
    </style>
</head>

<body>
    <div style="text-align:center">
        <h3> <?= $dataqrcode[0]['item']?></h3>
        <p><?=$dataqrcode[0]['redemption_number'] ?></p>
    </div>
    <table id="table">
        <?php $rowCount = 0; ?>
        <?php 
            foreach ($dataqrcode as $dataqrcodes) { ?>
        <!-- echo var_dump($dataqrcodes['picturebase']);exit; -->
        <?php    
                if ($rowCount == 0) { ?>
        <tr>
            <?php    
                }
            ?>
            <td><img src="<?=$dataqrcodes['picturebase'];?>" alt="Cinque Terre" width="200" height="200"></td>
            <?php 
                $rowCount++; 
                if ($rowCount == 4) { 
         ?>
        </tr>
        <?php
                    $rowCount = 0;    
                }
        ?>
        <?php
            }
            if ($rowCount > 0) {
                while ($rowCount < 4) { ?>
        <td></td>
        <?php   $rowCount++;
                } ?>
        </tr>
        <?php    } 
        ?>
        <tbody>
            <tr>

            </tr>
        </tbody>
    </table>
</body>

</html>