<?php
 include_once ('Classes/Stock.php');
include_once ('Classes/Stocks.php');
include_once('Classes/User.php');
$user = new User($_GET['userID']);
$list = $user->FavoritsList;


//$Stocks = new Stocks();
//$list = $Stocks->getFirstStocks();
 ?>  
 <!DOCTYPE html>  
 <html>  
      <head>  
           <title>Stock Site | My Favorites</title>  
           <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>  
           <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />  
           <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>  
           <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>            
           <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" />  
      </head>  
      <body>  
           <br /><br />  
           <div class="container">  
              <h1><?php echo $user->Name; ?>'s Favorites </h1>
                <br />  
                <div class="table-responsive">  
                     <table id="stock_data" class="table table-striped table-bordered">  
                          <thead>  
                               <tr>  
                                    <td>symbol</td>  
                                    <td>name</td>  
                                    <td>sector</td>  
                                    <td>industry</td>  
                                    <td>price</td>  
                                    <td>exDate</td>  
                                    <td>volume</td>  
                                    <td>precentchange</td>  
                                    <td>dividendamount</td>  
                                    <td>dividenddate</td>  
                               </tr>  
                          </thead>  
                          <?php  
                          foreach ($list as $stock){ 
                               echo '  
                               <tr>  
                                    <td>'.$stock->Symbol.'</td>  
                                    <td>'.$stock->Name.'</td>  
                                    <td>'.$stock->Sector.'</td>  
                                    <td>'.$stock->Industry.'</td>  
                                    <td>'.$stock->Price.'</td>  
                                    <td>'.$stock->EXDate.'</td>  
                                    <td>'.$stock->Volume.'</td>  
                                    <td>'.$stock->PercentChange.'</td>
                                    <td>'.$stock->DividendAmount.'</td> 
                                    <td>'.$stock->DividendDate.'</td>
                               </tr>  
                               ';  
                          }  
                          ?>  
                     </table>  
                </div>  
           </div>  
      </body>  
 </html>  
 <script>  
 $(document).ready(function(){  
      $('#stock_data').DataTable();  
 });  
 </script>