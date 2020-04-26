<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <!-- Latest compiled and minified CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />

    <title>Hello, world!</title>
    <style>
        .hr-success {
            height: 10px;
        }

        .tox-notifications-container {
            display: none;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col">
                <form method="post" action="<?php echo yii\helpers\Url::to(['login/logout']) ?>">
                    <button class="btn btn-warning logout">Logout</button>
                </form>
                 <div class="d-flex justify-content-between">
                    <h4>File Changed Notification</h4>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="d-flex justify-content-between">
                <h4>Deleted File</h4>
            </div>
            <div class="table-responsive">
                <table class="table table-hover table-sm">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">File Name</th>
                            <th scope="col">File Type</th>
                            <th scope="col">File Url</th>
                            <th scope="col">Deleted at</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if($deleted_files_array) {
                          $count = 1 ;
                          foreach ($deleted_files_array as $key => $value) {    
                        ?>
                            <tr id="row_1">
                                <td><?php echo $count; ?></td>
                                <td><?php echo $value['file_name']; ?></td>
                                <td><?php echo $value['type']; ?></td>
                                <td><?php echo $value['file_url'] ?></td>
                                <td><?php echo $value['last_updated_at'] ?></td>
                                
                            </tr>
                        <?php $count++ ; } }  else { ?>    
                            <tr>
                                <td colspan="5" style="text-align: center">No Files deleted</td>
                            </tr>
                        <?php } ?>    
                    </tbody>
                </table>
            </div>
            <hr class="hr-success" />
        </div>
        <div class="col-12">
            <div class="d-flex justify-content-between">
                <h4>Added New Files</h4>
            </div>
            <div class="table-responsive">
                <table class="table table-hover table-sm">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">File Name</th>
                            <th scope="col">File Type</th>
                            <th scope="col">File Url</th>
                            <th scope="col">Added at</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if($new_files_array) {
                          $count = 1 ;
                          foreach ($new_files_array as $key => $value) {
                             
                        ?>
                        <tr>
                            <td><?php echo $count; ?></td>
                            <td><?php echo $value['file_name']; ?></td>
                            <td><?php echo $value['type']; ?></td>
                            <td><?php echo $value['file_url'] ?></td>
                            <td><?php echo $value['last_updated_at'] ?></td>
                        </tr>
                        <?php $count++; } } else { ?>
                            <tr>
                                <td colspan="5" style="text-align: center">No New files added</td>
                            </tr>
                        <?php } ?>    
                    </tbody>
                </table>
            </div>
            <hr class="hr-success" />
        </div>
        <div class="col-12">
            <div class="d-flex justify-content-between">
                <h4>Updated Files</h4>
            </div>
            <div class="table-responsive">
                <table class="table table-hover table-sm">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">File Name</th>
                            <th scope="col">File Type</th>
                            <th scope="col">File Url</th>
                            <th scope="col">Updated at</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if($updated_files_array) {
                          $count = 1 ;
                          foreach ($updated_files_array as $key => $value) {
                             
                        ?>
                        <tr>
                            <td><?php echo $count; ?></td>
                            <td><?php echo $value['file_name']; ?></td>
                            <td><?php echo $value['type']; ?></td>
                            <td><?php echo $value['file_url'] ?></td>
                            <td><?php echo $value['last_updated_at'] ?></td>
                        </tr>
                        <?php $count++; } } else { ?>
                           <tr>
                               <td colspan="5" style="text-align: center">No file Updated</td>
                           </tr> 
                        <?php } ?>   
                    </tbody>
                </table>
            </div>
            <hr class="hr-success" />
        </div>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
        integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n"
        crossorigin="anonymous"></script>
     <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
        crossorigin="anonymous"></script>
    
  
    <script>

    </script>
</body>

</html>