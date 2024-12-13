<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $pageTitle ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgICS+VKNBQNGCHeKRQN+PtmoHDEXuppvnDIzQIu9" crossorigin="anonymous">
    <style>
        /* Initial background image */
        body {
            background-image: url('Images/ford_mustang1.jpg');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            color: white; /* Adjust text color for visibility on the background */
            transition: background-image 1s ease-in-out; /* Smooth transition between backgrounds */
        }

        /* Navbar styles */
        .navbar {
            background-color: rgba(0, 0, 0, 0.6); /* Transparent black for navbar */
        }

        .navbar a {
            color: white !important; /* White text for the navbar links */
        }

        .navbar a:hover {
            color: #FFD700 !important; /* Gold color on hover */
        }
        
        .container {
            max-width: 90%; /* To prevent the content from being too wide */
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        <nav class="navbar navbar-expand-lg navbar-dark">
            <div class="container-fluid">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav mx-auto">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="/">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="cars.php">Cars</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="users.php">Users</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="trips.php">Trips</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="reservations.php">Reservations</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="lib1.php">Pie Chart of Car Models</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="lib2.php">Car Count By Location and Year</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="lib3.php">Car Availability Over Time (By Month)</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="lib4.php">Distribution of Cars by Location</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>
    
    <!-- JavaScript to change background image -->
    <script>
        let currentBackground = 0;
        const backgrounds = [
            'Images/ford_mustang1.jpg',
            'Images/mercedez1.jpg'
        ];

        setInterval(function() {
            document.body.style.backgroundImage = `url('${backgrounds[currentBackground]}')`;
            currentBackground = (currentBackground + 1) % backgrounds.length;
        }, 5000); // Switch every 5 seconds
    </script>
</body>
</html>
