<?php
require '../db.php';
require '../functions.php';
check_auth();
if ($_SESSION['user']['role'] !== 'admin') {
    echo "Access Denied.";
    exit; // Prevent further execution
}
$query = "SELECT * FROM building_details";
$stmt = $pdo->prepare($query); 
$stmt->execute();
?>

<?php
include("./includes/header.php"); 
include("./includes/sidenav.php"); 
?>

        <!-- ========Main========== -->
         <div class="main">
            <?php include("./includes/topbar.php"); ?>
            <div class="building_container">
                <div class="building_table_details">
                    <div class="building_btn">
                        <button><a href="./add_building.php">Add new Building</a></button>
                    </div>
                    <table>
                        <thead>
                            <th>Si</th>
                            <th>Building</th>
                            <th>Floor</th>
                            <th>Unit</th>
                            <th>Apartment</th>
                            <th>Action</th>
                        </thead>
                            <?php
                            $si = 1;
                            while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                                echo "<tbody>";
                                echo "<td>".$si++."</td>";
                                echo "<td>".htmlspecialchars($row['building_name'])."</td>";
                                echo "<td>".htmlspecialchars($row['number_of_floor'])."</td>";
                                echo "<td>".htmlspecialchars($row['number_of_unit'])."</td>";
                                $apartment_names = htmlspecialchars($row['apartment_name']);
                                // echo $apartment_name;
                                $apartments_array = explode(", ", $apartment_names);
                                sort($apartments_array);
                                $simplified_apartments = implode(", ", $apartments_array);
                                echo "<td>".$simplified_apartments."</td>";
                                
                            
                                echo "<td>
                                        <a href='edit_building.php?id=" . $row['id'] . "' class='edit'>Edit</a>
                                        <a href='delete_building.php?id=" . $row['id'] . "' class='dlt'>Delete</a>
                                    </td>";
                                echo "<tbody>";
                            }
                            ?>
                            </tbody>
                            
                    </table>
                </div>
            </div>
            
            
            
            
<?php include("./includes/footer.php") ?>