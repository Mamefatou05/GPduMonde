<?php
$page = isset($_GET['page']) ? $_GET['page'] : 'dashboard';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion de cargaison</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="../dist/styles.css" rel="stylesheet">

</head>

<body class="bg-gray-100">
    <header class="bg-white shadow">
    <?php include 'Components/navbar.php'; ?>
    </header>
    <div class="flex">
        <?php include 'Components/sidebar.php'; ?>
        <main class="flex-1 p-6">
                <?php
                switch ($page) {
                    case 'dashboard':
                        include 'dashboard.php';
                        break;
                    case 'contact':
                        include 'contact.php';
                         break;
                    case 'cargaisons':
                        include 'cargaisons.php';
                        break;
                    case 'cargaison_detail':
                        include 'cargaison_detail.php';
                        break;
                    default:
                        include 'dashboard.php';
                }
                ?>
        </main>
    </div>
    <footer>    <?php include 'Components/footer.php'; ?>
</footer>
</body>

</html>