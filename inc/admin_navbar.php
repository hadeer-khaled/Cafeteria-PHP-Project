<!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->

<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="#">Cafeteria</a>
  
  <!-- Toggler button -->
  <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <!-- Navbar links -->
  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item">
        <a class="nav-link" href="#">
          Home
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="../pages/products_table.php">
           Products
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">
          Users
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">
           Orders
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">
         Checks
        </a>
      </li>
    </ul>
  </div>

  <!-- User's image, name, and logout button on the right -->
  <div class="navbar-nav ml-auto">
    <a class="nav-link" href="#">
      <img src="../assets/images/redhat.jpg" alt="User Image" width="30" height="30" class="d-inline-block align-top rounded-circle">
      Admin
    </a>
    <a class="nav-link" href="logout.php">Logout</a>
  </div>
</nav>
