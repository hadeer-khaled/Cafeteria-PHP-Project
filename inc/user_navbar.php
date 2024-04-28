
<link href="../assets/css/style.css" rel="stylesheet">
<nav class="navbar navbar-expand-lg p-2" style="background: #202738;">
  <a class="navbar-brand mx-2" style="color: white;"href="#">
  <img src="../assets/images/cafeteria.png" alt="Logo " width="100"  class="d-inline-block align-top">
  
  </a>
  
  <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item">
        <a class="nav-link active" aria-current="page"   style="color: white;" href="./">
          Home
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link"  style="color: white;" href="./myOrders.php">
           My Orders
        </a>
      </li>
    </ul>
  </div>

  <div class="navbar-nav ml-auto" style ="display: flex;
    justify-content: center;
    align-items: center;">
    <a class="nav-link"  style="color: white;" href="#">
      <img src="../assets/images/redhat.jpg" alt="User Image" width="30" height="30" class="d-inline-block align-top rounded-circle">
      <?php echo $_SESSION['username']; ?>
    </a>
    <a class="nav-link" href="../handlers/logout.php"><i class="fa-solid fa-right-from-bracket" style = "font-size: 22px;
    color: #C46B48;"></i></a>
  </div>
</nav>
