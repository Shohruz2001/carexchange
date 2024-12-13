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
            background-color: rgba(0, 0, 0, 0.85); /* Slightly darker for better visibility */
            padding: 1.5rem 2rem; /* Adjusted padding for better spacing */
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.4); /* Enhanced shadow effect */
        }

        .navbar-brand {
            font-size: 28px; /* Larger brand text */
            color: #FFD700 !important; /* Gold for brand */
            font-weight: bold;
        }

        .navbar-nav {
            display: flex;
            align-items: center;
            justify-content: space-around;
            font-size: 20px; /* Increased font size for navigation links */
        }

        .nav-link {
            color: white !important;
            text-decoration: none !important; /* Remove underline */
            font-weight: bold;
            padding: 12px 20px; /* Larger padding for better clickability */
            border-radius: 5px; /* Smooth button-like corners */
            transition: all 0.3s ease; /* Smooth hover transition */
        }

        .nav-link:hover {
            background-color: #FFD700; /* Gold hover background */
            color: black !important; /* Black text on hover */
            text-shadow: 0 0 10px #FFD700; /* Glow effect */
        }

        /* Responsive navbar adjustments */
        @media (max-width: 768px) {
            .navbar-nav {
                flex-direction: column;
                align-items: flex-start;
            }

            .nav-link {
                font-size: 18px; /* Slightly smaller for smaller screens */
                margin-bottom: 10px; /* Add spacing for stacked items */
            }
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <a class="navbar-brand" href="/">Car Exchange</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="/">Home</a>
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
