<?php include("database.php");

$condition = "";
$inPage = 10; // content limit per page

if (isset($_POST['search'])) {
    $condition = " WHERE authors.author like '%" . $_POST['search'] . "%' ";
}
//total datas
$sql = $pdo->query("SELECT count(*) as total
FROM authors
LEFT JOIN books ON books.author_id = authors.id" . $condition);

$result = $sql->fetch(PDO::FETCH_ASSOC);
$totalContent = $result['total'];

$totalPage = ceil($totalContent / $inPage);
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;


if ($page < 1) {
    $page = 1;
}

?>
<!doctype html>
<html lang="en">
<head>
    <meta http-equiv="Content-type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Books List</title>
    <link rel="stylesheet" href="//cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="js/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
    <style>
        table {
            position: relative;
        }

        .tr {
            position: absolute;
            top: 0;
            right: 0;
        }

        .pagination {
            bottom: 100px;
            position: fixed;
        }

        .header {
            color: #333;
        }

        .header:hover {
            color: #3c3c3c;
            text-decoration: none;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-md-12"><br>
            <nav class="navbar navbar-light bg-light justify-content-between">
                <form class="form-inline" method="POST" action="#">
                    <h1 class="col-md-8"><a href="index.php" class="header"> Books List</a></h1>
                    <div class="col-md-4" style="margin-top: 35px">
                        <input class="form-control" name="search" value="<?= @$_POST['search']; ?>" type="search"
                               placeholder="Author Search" aria-label="Search">
                        <button class="btn btn-success my-2 my-sm-0" type="submit">Search</button>
                    </div>
                </form>
            </nav>
            <table class="table table-striped">
                <thead>
                <tr>
                    <th scope="col">Book ID</th>
                    <th scope="col">Author</th>
                    <th scope="col">Book Name</th>
                </tr>
                </thead>
                <tbody>
                <?php $limit = ($page - 1) * $inPage;
                $limitCondition = "";
                if (!isset($_POST['search'])) {
                    $limitCondition = " LIMIT " . $inPage . " OFFSET " . $limit;
                }
                $res = $pdo->query('SELECT books.id
                                            , books.book
                                            , authors.author
                                            FROM authors LEFT JOIN books ON books.author_id = authors.id
                                             ' . $condition . '
                                           ORDER BY books.id ASC ' . $limitCondition . '');
                $datas = $res->fetchAll(PDO::FETCH_ASSOC);
                if ($datas) {
                    foreach ($datas as $data) { ?>
                        <tr class="tr">
                            <th style="width: 10%"><?= $data['id']; ?></th>
                            <td style="width: 45%"><?= $data['author']; ?></td>
                            <td style="width: 45%"><?= $data['book']; ?></td>
                        </tr>

                    <?php }
                } else { ?>
                    <tr>
                        <th scope="row" colspan="3" style="text-align: center">No Record</th>
                    </tr>
                <?php } ?>
                </tbody>
            </table>

            <nav aria-label="Page navigation example">
                <ul class="pagination">
                    <?php echo "<h5>Total Record = $totalContent</h5>"; ?>
                    <?php for ($s = 1; $s <= $totalPage; $s++) {
                        if ($page == $s) {
                            echo '<li class="page-item active"><a class="page-link" href="#">' . $s . '</a></li>';
                        } else {
                            echo ' <li class="page-item"><a class="page-link" href="index.php?page=' . $s . '">' . $s . '</a></li> ';
                        }
                    }
                    ?>
                </ul>
            </nav>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        var left = $('.tr').offset().left;
        $(".tr").hide();
        $(".tr").each(function (index) {
            $(this).delay(index * 500).fadeIn(1000);
            $(this).css({left: left, 'position': 'relative'}).animate({"left": "0px"}, (index - 1) * 100);

        });
    })

</script>
</body>
</html>
