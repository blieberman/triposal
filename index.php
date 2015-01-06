<!DOCTYPE html>
<html lang="en">
  <head>
    <?php include 'header.php'; ?>
  </head>

  <body>
    <?php include_once("analyticstracking.php") ?>
    <div class="jumbotron masthead">
      <div class="container">
        <h1>Triposal</h1>
        <p>The travel search decision maker.</p>
        <p><a data-toggle="modal" href="#planner" class="btn btn-primary btn-large">Get Started</a></p>
          <ul class="masthead-links">
					<center>
            <li>Version 0.0.2</li>
            <li>Ben Lieberman</li>
            <li>&copy; 2015</li>
					</center>
          </ul>
      </div>
    </div>
    <?php include 'modals.php'; ?>
  </body>
</html>