<!DOCTYPE html>
<html lang='en'>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" href="style.css">
        <title>Receipt</title>
    </head>
<?php
    require_once 'dbh.php';

    $protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
    $getURI = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    $_SESSION['getURI'] = $getURI.'?';

    if(isset($_GET['id'])){
        $id = $_GET['id'];
    }


    // check if user is pwd
    $user_id = $_SESSION['user_id'];
    $is_pwd = 0;
    $checkPWD = $mysqli->query("SELECT * FROM pwd WHERE user_id = '$user_id' AND validated = '1' ") or die($mysqli->error);

    if (mysqli_num_rows($checkPWD) > 0) {
        $is_pwd = 1;
    }

    $getTransaction = mysqli_query($mysqli, "SELECT * FROM transaction t
    JOIN pharmacy_store ps
    ON ps.id = t.pharmacy_id
    LEFT JOIN cart c
    ON c.transaction_id = t.id
    JOIN pharmacy_products pp
    ON pp.id = c.product_id WHERE t.id = '$id' ");
    $newTransaction = $getTransaction->fetch_array();

    $getTransactionLists = mysqli_query($mysqli, "SELECT * FROM transaction t
    JOIN pharmacy_store ps
    ON ps.id = t.pharmacy_id
    LEFT JOIN cart c
    ON c.transaction_id = t.id
    JOIN pharmacy_products pp
    ON pp.id = c.product_id WHERE t.id = '$id'");
?>
<body>
        <div class="ticket">
            <center>PharmaClique</center>
            <p class="centered">Official Receipt --- <?php echo '#0000'.$id; ?>

            <p class="centered"><i><?php if($is_pwd){echo 'with PWD Discount'; } ?></i></p>
                <!-- <br>Address line 1
                <br>Address line 2</p> -->
            <table>
                <thead>
                    <tr>
                        <th class="quantity">Q.</th>
                        <th class="description">Description</th>
                        <th class="price">₱₱</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $total = 0;
                    while ($newTransactionList=$getTransactionLists->fetch_assoc()){
                    ?>
                    <tr>
                    <td><?php echo $newTransactionList['count'].' pc(s)'; ?></td>
                    <td><?php echo strtoupper($newTransactionList['product_name']); ?></td>
                    <td>₱ <?php echo number_format($newTransactionList['subtotal'],2); ?></td>
                    </tr>
                    <?php
                            $total = $newTransactionList['total_amount'];
                            $storeName = $newTransactionList['store_name'];
                            }
                    ?>
                </tbody>
                <tr>
                    <td colspan="3"><a style="float: right;">Total: ₱<?php echo $total; ?> <i>(with Delivery Charge ₱49.90)</i></a></td>
                </tr>
            </table>
            <p class="centered">Store: <?php echo $storeName; ?></p>

            <p class="centered">Thank you for your purchase!</p>
            <br>
            <p class="centered">____________________</p>
        </div>
        <button id="btnPrint" class="hidden-print">Print</button>
        <script src="script.js"></script>
    </body>
<script>
    const $btnPrint = document.querySelector("#btnPrint");
    $btnPrint.addEventListener("click", () => {
    window.print();
    });
</script>
    <style>
    * {
    font-size: 12px;
    font-family: 'Times New Roman';
    }

    td,
    th,
    tr,
    table {
        border-top: 1px solid black;
        border-collapse: collapse;
    }

    td.description,
    th.description {
        width: 75px;
        max-width: 75px;
    }

    td.quantity,
    th.quantity {
        width: 40px;
        max-width: 40px;
        word-break: break-all;
    }

    td.price,
    th.price {
        width: 40px;
        max-width: 40px;
        word-break: break-all;
    }

    .centered {
        text-align: center;
        align-content: center;
    }

    .ticket {
        width: 155px;
        max-width: 155px;
    }

    img {
        max-width: inherit;
        width: inherit;
    }

    @media print {
        .hidden-print,
        .hidden-print * {
            display: none !important;
        }
    }
    </style>

</html>    
