<?php
  require '../db.php';
  require '../functions.php';
  check_auth();
  if ($_SESSION['user']['role'] !== 'admin') {
      echo "Access Denied.";
      exit; // Prevent further execution
  }
  $support_staff = $pdo->query("SELECT name, phone, employee_id FROM support_staff ORDER BY created_at DESC");
  $tickets = $pdo->query("SELECT t.*, u.name as user_name FROM tickets t JOIN users u ON u.id=t.user_id ORDER BY t.created_at DESC")->fetchAll();
  $users = $pdo->query("SELECT id,name,email,role FROM users ORDER BY id DESC")->fetchAll();
?>

<?php 
include("./includes/header.php"); 
include("./includes/sidenav.php"); 
?>
        


        <!-- ========Main========== -->
         <div class="main">
            <?php include("./includes/topbar.php"); ?>


            <!-- ======CardBox====== -->
            <div class="cardbox">
                <div class="card">
                    <div>
                        <div class="numbers">1,500</div>
                        <div class="CardName">Pending</div>
                    </div>
                    <div class="iconbx">
                        <ion-icon name="eye-outline"></ion-icon>
                    </div>
                </div>

                <div class="card">
                    <div>
                        <div class="numbers">280</div>
                        <div class="CardName">In Process</div>
                    </div>
                    <div class="iconbx">
                        <ion-icon name="chatbubble-ellipses-outline"></ion-icon>
                    </div>
                </div>

                <div class="card">
                    <div>
                        <div class="numbers">80</div>
                        <div class="CardName">Solved</div>
                    </div>
                    <div class="iconbx">
                        <ion-icon name="cart-outline"></ion-icon>
                    </div>
                </div>
                <!-- <div class="card">
                    <div>
                        <div class="numbers">$1,900</div>
                        <div class="CardName">Earnings</div>
                    </div>
                    <div class="iconbx">
                        <ion-icon name="cash-outline"></ion-icon>
                    </div>
                </div> -->
            </div>


            <!-- ========order Details======== -->
             <div class="details">
                <div class="recentOrders">
                    <div class="cardHeader">
                        <h2>Recent Tickets</h2>
                        <a href="" class="btn">view All</a>
                    </div>

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
                            <?php foreach($tickets as $t): ?>
                                <tr>
                                    <td><?=h($t['id'])?></td>
                                    <td><?=h($t['category'])?></td>
                                    <td><?= date('d M y', strtotime($t['created_at'])) ?></td>
                                    <td>Toru Neer</td>
                                    <td><span class="status <?= h($t['status']) == 'On Process' ? 'inprocess' : (h($t['status']) == 'pending' ? 'pending' : 'delivered') ?>"><?=h($t['status'])?></span></td>
                                    <td><a href="view_ticket.php?id=<?= $t['id'] ?>"><ion-icon name="return-down-back-outline"></ion-icon></a></td>
                            </tr>
                            <?php endforeach; ?>
                            <!-- <tr>
                                <td>1</td>  
                                <td>Parking Problem</td>  
                                <td>19 Sep 25</td>
                                <td>Toru Neer</td>
                                <td><span class="status inprocess">In Process</span></td> 
                                <td><a href=""><ion-icon name="return-down-back-outline"></ion-icon></a></td>
                                <td><a href="">action</a></td> 
                            </tr> -->
                            <!-- <tr>
                                <td>1</td>  
                                <td>Parking Problem</td>  
                                <td>19 Sep 25</td>
                                <td>Toru Neer</td>
                                <td><span class="status inprocess">In Process</span></td> 
                                <td><a href=""><ion-icon name="return-down-back-outline"></ion-icon></a></td>
                                <td><a href="">action</a></td> 
                            </tr>
                            <tr>
                                <td>1</td>  
                                <td>Parking Problem</td>  
                                <td>19 Sep 25</td>
                                <td>Toru Neer</td>
                                <td><span class="status inprocess">In Process</span></td> 
                                <td><a href=""><ion-icon name="return-down-back-outline"></ion-icon></a></td>
                                <td><a href="">action</a></td> 
                            </tr> -->

                            <!-- <tr>
                                <td>Star Refrigarator</td>  
                                <td>$1200</td>  
                                <td>Paid</td>  
                                <td><span class="status pending">Pending</span></td>  
                            </tr>

                            <tr>
                                <td>Star Refrigarator</td>  
                                <td>$1200</td>  
                                <td>Paid</td>  
                                <td><span class="status inprocess">In Process</span></td>  
                            </tr>

                            <tr>
                                <td>Dell laptop</td>  
                                <td>$1200</td>  
                                <td>Paid</td>  
                                <td><span class="status delivered">Delived</span></td>  
                            </tr>

                            <tr>
                                <td>Oven</td>  
                                <td>$1700</td>  
                                <td>Paid</td>  
                                <td><span class="status pending">Pending</span></td>  
                            </tr>
                            <tr>
                                <td>Star Refrigarator</td>  
                                <td>$1200</td>  
                                <td>Paid</td>  
                                <td><span class="status delivered">Delived</span></td>  
                            </tr>

                            <tr>
                                <td>Star Refrigarator</td>  
                                <td>$1200</td>  
                                <td>Paid</td>  
                                <td><span class="status pending">Pending</span></td>  
                            </tr>

                            <tr>
                                <td>Star Refrigarator</td>  
                                <td>$1200</td>  
                                <td>Paid</td>  
                                <td><span class="status inprocess">In Process</span></td>  
                            </tr>

                            <tr>
                                <td>Dell laptop</td>  
                                <td>$1200</td>  
                                <td>Paid</td>  
                                <td><span class="status delivered">Delived</span></td>  
                            </tr>

                            <tr>
                                <td>Oven</td>  
                                <td>$1700</td>  
                                <td>Paid</td>  
                                <td><span class="status pending">Pending</span></td>  
                            </tr> -->
                        </tbody>
                    </table>
                </div>

                <!-- ========USER======== -->
                 <div class="recentUser">
                    <div class="cardHeader">
                        <h2>Staff</h2>
                        <a href="" class="btn">view All</a>
                    </div>
                    <table>
                        <?php
                            if($support_staff->rowCount() > 0){
                                while($row = $support_staff->fetch()){
                                    echo '<tr>';
                                    echo '<td width="60px">';
                                    // echo '<div class="imgbx"><img src="./assets/imgs/' . $row['image'] . '" alt=""></div>';
                                    echo '<div class="imgbx"><img src="./assets/imgs/customer2.jpg" alt=""></div>';
                                    echo '</td>';
                                    echo '<td>';
                                    echo '<h4>' . $row['name'] . '</h4><span>' . $row['phone'] . '</span>';
                                    echo '</td>';
                                    echo '</tr>';
                                }
                            }else{
                                echo "No results found.";
                            }
                        ?>
                        <!-- <tr>
                            <td width="60px">
                                <div class="imgbx"><img src="./assets/imgs/customer2.jpg" alt=""></div>
                            </td>
                            <td>
                                <h4>David</h4><span>Italy</span>
                            </td>
                        </tr> -->

                        
                    </table>
                 </div>
             </div>
         </div>
     </div>
     <!-- =============script========== -->
      <?php include("./includes/footer.php") ?>