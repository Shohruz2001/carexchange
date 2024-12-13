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
            background-color: rgba(0, 0, 0, 0.8); /* Slightly darker transparent black for better visibility */
            padding: 1rem 2rem; /* Add padding for better spacing */
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.3); /* Subtle shadow for depth */
        }

        .navbar-nav {
            display: flex !important; /* Force horizontal layout */
            flex-direction: row !important; /* Align items in a row */
        }

        .nav-item {
            margin-right: 25px; /* Add more spacing between links */
        }

        .navbar a {
            color: white !important; /* White text for the navbar links */
            text-decoration: none !important; /* Remove underline */
            font-weight: bold; /* Make text bold */
            font-size: 20px; /* Increase font size */
            padding: 10px 15px; /* Add padding for better click area */
            border-radius: 5px; /* Rounded corners for buttons */
            transition: all 0.3s ease; /* Smooth transition for hover effect */
        }

        .navbar a:hover {
            color: black !important; /* Black text on hover */
            background-color: #FFD700 !important; /* Gold background on hover */
            text-shadow: 0 0 10px #FFD700; /* Glow effect */
        }

        .navbar-brand {
            font-size: 24px; /* Larger brand text */
            color: #FFD700 !important; /* Gold color for brand name */
            font-weight: bold;
        }

        /* Ensure content is properly spaced and aligned */
        .container {
            max-width: 90%; /* Prevent the content from being too wide */
        }

        /* Responsive navbar adjustments */
        @media (max-width: 768px) {
            .navbar-nav {
                flex-direction: column !important; /* Stack items vertically on smaller screens */
            }

            .nav-item {
                margin-right: 0; /* Reset spacing */
                margin-bottom: 10px; /* Add bottom margin */
            }
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        <nav class="navbar navbar-expand-lg navbar-dark">
            <div class="container-fluid">
                <a class="navbar-brand" href="/">Car Exchange</a>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwvvtgBNo3bZJLYd80VXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmn1MuBnhbgnk" crossorigin="anonymous"></script>
</body>
</html>
