<?php
	session_start();
?>
<!DOCTYPE HTML>
<!--
	Template Theme modified for Development Project 1: Tools and Practices Open Project Assignment - "Arcana by HTML5 UP"
	Lisence: Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->
<html>
	<head>
		<title>Group Assignment - Scheduler</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<link rel="stylesheet" href="assets/css/main.css" />
	</head>
	<body>
		<div id="page-wrapper">
			<div id="header">
				<h1><a href="index.php" id="logo">Group Assignment <em>Scheduler</em></a></h1>
				<nav id="nav">
					<ul>
						<li><a href="index.php" class="current">Home</a></li>
						<li><a href="teams.php">Teams</a></li>
						<li>
							<a href="schedule.php">Scheduler</a>
							<ul>
								<li><a href="schedule.php">New Meeting</a></li>
								<li><a href="conflicts.php">Conflicts</a></li>
								<li><a href="manage.php">Management</a></li>
							</ul>
						</li>
						<li><a href="meetings.php">Scheduled Meetings</a></li>
						<li><a href="settings.php">Settings</a></li>
						<?php
							if (isset($_SESSION['username'])) {
								echo "<li><a href='logout.php'>Logout</a></li>";
							} else {
								echo "<li><a href='logout.php'>Logout</a></li>";
							}
						?>
					</ul>
				</nav>
			</div>
			<section class="wrapper style2">
				<div class="container">
					<header class="major">
						<h2>Conflict Resolver</h2>
						<p>Meeting Time Conflicts</p>
					</header>
					<div>
						<?php
							if (isset($_SESSION['username'])) {
								echo "<p style=\"text-align:center;\">Logged in as <strong>" . $_SESSION['username'] . "</strong>.</p>";
							} else {
								echo "<p style='text-align:center;'>You are not logged in. <strong>Please login to see scheduled meetings.</strong></p>";
								session_start();
							}
			
							if (isset($_SESSION['username'])) {
								// connection info
								$host = "127.0.0.1";
								$user = "root";
								$pwd = "redtango";
								$sql_db = "openproject";

								$conn = @mysqli_connect($host, $user, $pwd, $sql_db);

								/*Simple Function to Santise Input
								Applies several input santiation Methods*/
								function sanitise_input($data) {
									$data = trim($data);
									$data = stripslashes($data);
									$data = htmlspecialchars($data);
									return $data;
								}

								function display_table($result){
									// Display the retrieved records
									// retrieve current record pointed by the result pointer
									while ($row = mysqli_fetch_assoc($result)){
										echo "<form name='schedule' method='post' action='processconflicts.php'>";
										

										if ($row["meetpref1"] < 3 && $row["meetpref2"] < 3 && $row["meetpref3"] < 3) {
											echo "<table border='1'>";
											echo "<tr>"
											."<th scope='col'><strong>Meeting Time</strong></th>"
											."<th scope='col'><strong>Vote</strong></th>"
											."</tr>";

											echo "<p><strong>Vote a timeslot for ",$row["title"],":</p></strong>";
											echo "<tr>";
											echo "<td>",$row["meet1"],"</td>";
											echo "<td> <input type='radio' name='select' value='meet1'> </td>";
											echo "</tr>";
											echo "<tr>";
											echo "<td>",$row["meet2"],"</td>";
											echo "<td> <input type='radio' name='select' value='meet2'> </td>";
											echo "</tr>";
											echo "<tr>";
											echo "<td>",$row["meet3"],"</td>";
											echo "<td> <input type='radio' name='select' value='meet3'> </td>";
											echo "<input type='hidden' name='meeting' value='", $row["title"] ,"'>";
											echo "</tr>";

											echo "</table>";
											echo "<p><input type='submit' name='Submit' value='Set'></p>";
										}

										echo "</form>";
									}

									// Frees up the memory, after using the result pointer
									mysqli_free_result($result);
								}

								if (!$conn) {
									// Displays an error message
									echo "<p>Database connection failure</p>"; // connection failure message
								}

								//Define Database
								$sql_table="meetings";

								$id = $_SESSION['id'];

								$query_getmeetings = "SELECT * FROM meetings NATURAL JOIN teams NATURAL JOIN userteams WHERE userid=$id;";
								$result_getmeetings = mysqli_query($conn, $query_getmeetings);

								display_table($result_getmeetings);
								mysqli_close($conn);
							}
						?>
					</div>
				</div>
			</section>
			<!-- Footer -->
			<div id="footer">
				<!-- Icons -->
				<ul class="icons">
					<li><a href="#" class="icon fa-github"><span class="label">GitHub</span></a></li> <!-- Link Back to Github -->
					<li><a href="#" class="icon fa-google-plus"><span class="label">Google+</span></a></li> <!-- Leave for Google Cal API Integration -->
				</ul>
				<!-- Copyright -->
				<div class="copyright">
					<ul class="menu">
						<li>&copy; Swinburne University. All rights reserved</li><li>Design: <a href="#">Lachlan Haggart, Harrison Pace & Hoang Nguyen</a></li>
					</ul>
				</div>
			</div>
		</div>
		<!-- Scripts -->
		<script src="assets/js/jquery.min.js"></script>
		<script src="assets/js/jquery.dropotron.min.js"></script>
		<script src="assets/js/skel.min.js"></script>
		<script src="assets/js/util.js"></script>
		<script src="assets/js/main.js"></script>
	</body>
</html>
