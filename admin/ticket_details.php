<?php 
    include("./includes/header.php"); 
    include("./includes/sidenav.php");
?>

    <div class="main">
        <?php include("./includes/topbar.php"); ?>
        <div class="ticket_details">
            <table>
                <thead>
                    <tr>
                        <td>Id</td>
                        <td>Category</td>
                        <td>Create At</td>  
                        <td>Project</td>  
                        <td>Status</td> 
                        <td>Action</td>
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <td>1</td>
                        <td>Water Leakage</td>
                        <td>25 Jun 25</td>
                        <td>Rangs Diorama</td>
                        <td><span class="status inprocess">On Process</span></td>
                        <td><a href=""><ion-icon name="return-down-back-outline"></ion-icon></a></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php include("./includes/footer.php") ?>