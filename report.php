<?php
error_reporting(0);
	include("../function/session.php");
	include("../db/dbconn.php");
	$from=$_GET['from'];
	$to=$_GET['to'];
?>
<!DOCTYPE html>
<html>

<head>
    <title>LUMP-YUM</title>
    <link rel="stylesheet" type="text/css" href="../css/style.css" media="all">
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.css">
    <script src="../js/bootstrap.js"></script>
    <script src="../js/jquery-1.7.2.min.js"></script>
    <script src="../js/carousel.js"></script>
    <script src="../js/button.js"></script>
    <script src="../js/dropdown.js"></script>
    <script src="../js/tab.js"></script>
    <script src="../js/tooltip.js"></script>
    <script src="../js/popover.js"></script>
    <script src="../js/collapse.js"></script>
    <script src="../js/modal.js"></script>
    <script src="../js/scrollspy.js"></script>
    <script src="../js/alert.js"></script>
    <script src="../js/transition.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../javascripts/filter.js" type="text/javascript" charset="utf-8"></script>
    <script src="../jscript/jquery-1.9.1.js" type="text/javascript"></script>

    <!--Le Facebox-->
    <link href="../facefiles/facebox.css" media="screen" rel="stylesheet" type="text/css" />
    <script src="../facefiles/jquery-1.9.js" type="text/javascript"></script>
    <script src="../facefiles/jquery-1.2.2.pack.js" type="text/javascript"></script>
    <script src="../facefiles/facebox.js" type="text/javascript"></script>
    <script type="text/javascript">
    jQuery(document).ready(function($) {
        $('a[rel*=facebox]').facebox()
    })
    </script>

    <script language="javascript" type="text/javascript">
    function printFunc(divID) {
        //Get the HTML of div
        var divElements = document.getElementById(divID).innerHTML;
        //Get the HTML of whole page
        var oldPage = document.body.innerHTML;

        //Reset the page's HTML with div's HTML only
        document.body.innerHTML =
            "<html><head><title></title></head><body>" +
            divElements + "</body>";

        //Print Page
        window.print();

        //Restore orignal HTML
        document.body.innerHTML = oldPage;


    }
    </script>
</head>

<body>
    <div id="header" style="position:fixed;">
        <img src="../img/logo.png">
        <label>Meh Dessert</label>

        <?php
				$id = (int) $_SESSION['id'];
			
					$query = mysqli_query ($conn, "SELECT * FROM admin WHERE adminid = '$id' ") or die (mysqli_error());
					$fetch = mysqli_fetch_array ($query);
			?>

        <ul>
            <li><a href="../function/admin_logout.php"><i class="icon-off icon-white"></i>logout</a></li>
            <li>Welcome:&nbsp;&nbsp;&nbsp;<i class="icon-user icon-white"></i><?php echo $fetch['username']; ?></a></li>
        </ul>
    </div>

    <br>





    <?php include 'gilid.php';?>

    <div id="rightcontent" style="position:absolute; top:5%;">
        <div class="alert alert-info">
            <center>
                <h2>Summary report</h2>
            </center>
        </div>
        <div style="width:200px; position:fixed; margin-left:40%;">
            <form action="report.php" class="well" style="width:250px;">
                <h2>Select date</h2>
                <label for="from">FROM:
                    <input type="date" name="from"></label>

                <label for="from">TO:<br />
                    <input type="date" name="to"></label>
                <input type="submit" onclick="return confirm('Are you sure you want to generate?');"
                    class="btn btn-primary" value="generate">
            </form>
            <a href="print.php?from=<?php echo $from?>&to=<?php echo $to?>" target="_blank"
                class="btn btn-primary">Print</a>


        </div>

        <div style='width:400px;' class="alert alert-info">
            <table class="table table-hover">
                <thead>
                    <th>Beginning Balance:</th>
                    <th>
                        <?php 
		$Qs = mysqli_query($conn, "SELECT * FROM capital WHERE date >= '$from' AND date <= '$to'");
							while($rs = mysqli_fetch_array($Qs)){
							 
							$caps = $rs['amount']; 
							 
							echo 'Php '.number_format($caps, 2);
							}
							 
							 
							?>
                    </th>

                </thead>


            </table>

            <table class="table table-hover">
                <thead>
                    <th>OPERATING FUNDS:</th>
                </thead>

                <tbody>
                    <?php 
	$Q1 = mysqli_query($conn, "SELECT * FROM operatingfunds WHERE date >= '$from' AND date <= '$to'");
							while($r1 = mysqli_fetch_array($Q1)){
							
							$tid1 = $r1['name'];
							$tid2 = $r1['amount'];  
							 
							echo "<tr>";
							echo "<td>".$tid1."</td>";  
							echo "<td>".$tid2."</td>"; 
							echo "<td></td>"; 
							echo "<td></td>"; 
							echo "<td></td>"; 
							echo "<td></td>"; 
							echo "</tr>";
						 
							}
							 
							?>
                    <?php 
		$Q1 = mysqli_query($conn, "SELECT sum(amount) FROM operatingfunds WHERE date >= '$from' AND date <= '$to'");
							while($r1 = mysqli_fetch_array($Q1)){
							 
							$operatingfunds = $r1['sum(amount)'];  
							
							  
						    echo "<tr>";   
							echo "<td> Total opearting funds </td>"; 
							echo "<td></td>"; 
							echo "<td></td>"; 
							echo "<td>".$operatingfunds."</td>"; 
							echo "</tr>";
							}
							 
							?>
                    <?php 
		$Q3 = mysqli_query($conn, "SELECT sum(amount) FROM transaction WHERE order_stat='Confirmed' AND order_date >= '$from' AND order_date <= '$to'");
					while($r3 = mysqli_fetch_array($Q3)){
							
							$tid123 = $r3['sum(amount)'];
						 
							echo "<tr>";
							echo "<td> TOTAL OPERATING INCOME </td>";
								echo "<td></td>"; 
									echo "<td></td>"; 
							echo "<td>" .number_format($tid123, 2)."</td>"; 
							echo "</tr>";
							}
							
							?>
                </tbody>
            </table>

            <table class="table table-hover">
                <thead>
                    <th>OPERATING EXPENSE:</th>
                </thead>
                <tbody>
                    <?php 
		 	$Q1 = mysqli_query($conn, "SELECT * FROM expense WHERE date >= '$from' AND date <= '$to'");
							while($r1 = mysqli_fetch_array($Q1)){
							
							$tid1 = $r1['expense_type'];
							$tid2 = $r1['amount'];  
							
							echo "<tr>";
							echo "<td>".$tid1."</td>";  
							echo "<td>".$tid2."</td>"; 
							echo "<td></td>"; 
							echo "<td></td>"; 
							echo "<td></td>"; 
							echo "<td></td>"; 
							echo "</tr>";
						 
							}
							 
							?>
                </tbody>
                <tbody>
                    <?php 
			 $Q1 = mysqli_query($conn, "SELECT sum(amount) FROM expense WHERE date >= '$from' AND date <= '$to'");
							while($r1 = mysqli_fetch_array($Q1)){
							 
							$operatingexp = $r1['sum(amount)'];  
							
							  echo "<tr>";   
							echo "<td> Total opearting expense </td>"; 
							echo "<td></td>"; 
							echo "<td></td>"; 
							echo "<td>".$operatingexp."</td>"; 
							echo "</tr>";
							}
							 
							?>
                </tbody>
            </table>
            <?php
                        
                      $totalOP = $operatingfunds + $operatingexp; 
                        $gross=$tid123-$totalOP; 
                         $netincome= $caps - ($gross);
                        ?>

            <table class="table table-hover">
                <thead>
                    <th>Ending Balance:</th>
                    <th><?php echo 'Php '.number_format($netincome, 2); ?></th>
                </thead>

                <tbody>

                </tbody>
            </table>

        </div>


        <?php
				$id = (int) $_SESSION['id'];
			
					$query = mysqli_query ($conn, "SELECT * FROM admin WHERE adminid = '$id' ") or die (mysqli_error());
					$fetch = mysqli_fetch_array ($query);
					$users= $fetch['username']; 
					
			?>
        <?php if ($users=='adminko'){ ?>
        <div style="">
            <form action="../function/backupreset.php" method="POST">
                <input type="hidden" name="finalbalance" value="<?php echo $ends;?>" />
                <button type="submit" name="backupreset" onclick="return confirm('Do you want to reset the data?');"
                    class="btn btn-primary" style="width:200px;">back up</button>
            </form>
        </div>
        <?php }?>



    </div>

    </form>
    </div>
    </div>



</body>

</html>