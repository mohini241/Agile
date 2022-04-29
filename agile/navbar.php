<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <img class="fit-picture"
     src="agile.jpg" style="border-radius: 100%; height:76px; width:78px" >
  <a class="navbar-brand" href="#">Agile Project Management Software</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarText">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Leaderboard</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Performance Graphs</a>
      </li>
    </ul>
    <span class="navbar-text">

    
    <div class="dropdown">
  <button class="dropbtn" 
    style="padding: 10px 16px;
    font-size: 18px;
    line-height: 1.3333333;
    border-radius: 6px;
    margin-bottom:0px !important;">
    <p style="text-transform: capitalize;margin-bottom:0px !important;">Welcome <strong><?php echo $_SESSION['username'];  ?></strong></p></button>
    <div class="dropdown-content" style="width: 185px;">
    <a  href="index.php?logout='1'" style="color: #020202;">logout</a>
    </div>
  </div>
    </span>
  </div>
</nav>