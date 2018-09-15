<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
<link href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<!------ Include the above in your HEAD tag ---------->

<div class="container">
    <h1>Trip Sorter <small>(<i class="glyphicon glyphicon-filter"></i>)</small></h1>
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">Trips</h3>
                                           </div>
                    <br>
                    <ul>
                      <li><b>No DB structure found for trip sorter. Follow the instructions below:</b></li>
                      <li>Please Run the CLI on your system.</li>
                      <li>Make sure you are in the projects directory({{base_path()}}).</li>
                      <li>Enter the command <b>php artisan migrate</b> and hit Enter.</li>
                      <li>Then reset the server again.
                            <ol><li>Press CTRL+C</li>
                                <li>Enter the command <b>php artisan serve</b> and hit Enter.</li></ol>
                            </ol>
                                  </li>
                      <li>Enter the command <b>php artisan db:seed</b> If you want some dummy data to seed in DB</li>
                    </ul>
                </div>
            </div>
            
        </div>

       
        
    </div>

   