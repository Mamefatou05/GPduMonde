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
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.css" rel="stylesheet" />


</head>
<!-- <style>
    .bg-custom {
        background-image: url('../assets/bgCargo.jpg');
        background-size: cover;
        background-position: center;
    }

    .transition-bg {
        transition: background-color 0.3s ease;
    } -->
</style>
</head>

<body class="flex flex-col min-h-screen justify-between bg-custom bg-slate-50">

    <!-- <nav id="navbar" class="w-full fixed top-0 left-0 z-10 transition-bg"> -->
        <!---->
        <?php include 'Components/navbar.php'; ?>

    <!-- </nav> -->

    <!-- <main class="flex-grow pt-16 p-4">  -->
        <div class="flex flex-row"> 

            <?php include 'Components/sidebar.php'; ?>

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
            case 'produit':
                include 'produit.php';
                break;
            case 'detail':
                include 'details.php';
                break;
            default:
                include 'dashboard.php';
        }
        ?>


         </div>

      

    <!-- </main> -->

    <!-- <footer class="bg-white text-white text-center p-4"> -->
        <?php include 'Components/footer.php'; ?>
    <!-- </footer> -->



</body>

</html>
<script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>

<script>
    // document.getElementById('menu-button').addEventListener('click', function() {
    //     var menu = document.getElementById('menu');
    //     menu.classList.toggle('hidden');
    // });

    window.onscroll = function() {
        const navbar = document.getElementById("navbar");
        const navLinks = document.querySelectorAll(".nav-link");
        if (window.pageYOffset > 0) {
            navbar.classList.add("bg-white");
            navbar.classList.remove("bg-transparent");
            navLinks.forEach(link => {
                link.classList.add("text-black");
                link.classList.remove("text-white");
            });
        } else {
            navbar.classList.remove("bg-white");
            navbar.classList.add("bg-transparent");
            navLinks.forEach(link => {
                link.classList.add("text-white");
                link.classList.remove("text-black");
            });
        }
    };
</script>