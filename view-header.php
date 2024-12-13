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
            background-color: rgba(0, 0, 0, 0.9); /* Darker transparent background */
            padding: 1rem 2rem; /* Add padding for better spacing */
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.4); /* Shadow for depth */
        }

        .navbar-brand {
            font-size: 24px; /* Larger brand font size */
            color: white !important;
            font-weight: bold;
        }

        .navbar-nav {
            display: flex;
            align-items: center;
            justify-content: space-around;
        }

        .nav-link {
            color: white !important;
            text-decoration: none;
            font-weight: bold;
            font-size: 18px;
            padding: 10px 15px;
            transition: all 0.3s ease;
        }

        .nav-link:hover {
            background-color: #FFD700 !important; /* Gold hover effect */
            color: black !important;
            border-radius: 5px;
        }

        .dropdown-menu {
            background-color: rgba(0, 0, 0, 0.9); /* Dark dropdown background */
            border: none;
        }

        .dropdown-item {
            color: white !important;
            font-weight: bold;
        }

        .dropdown-item:hover {
            background-color: #FFD700;
            color: black !important;
        }

        /* Responsive navbar adjustments */
        @media (max-width: 768px) {
            .navbar-nav {
                flex-direction: column;
                align-items: flex-start;
            }

            .nav-link {
                font-size: 16px;
            }

            .dropdown-menu {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="/">Home</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Cars
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="cars.php">View Cars</a></li>
                            <li><a class="dropdown-item" href="add-car.php">Add Car</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="users.php">Users</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownTrips" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Trips
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdownTrips">
                            <li><a class="dropdown-item" href="trips.php">View Trips</a></li>
                            <li><a class="dropdown-item" href="create-trip.php">Create Trip</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="reservations.php">Reservations</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwvvtgBNo3bZJLYd80VXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmn1MuBnhbgnk" crossorigin="anonymous"></script>
</body>
</html>
