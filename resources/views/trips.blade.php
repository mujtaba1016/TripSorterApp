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
                    
                    <table class="table table-hover" id="dev-table">
                        <thead>
                            <tr>
                                <th>Trip Id</th>
                                <th>Trip Name</th>
                                <th>Trip Status</th>
                                <th>Enter Boarding cards Details</th>
                                <th>Sort</th>
                                </tr>
                        </thead>
                        <tbody>
                        <?php
                       foreach ($Trips as $trip) {
                                    echo "<tr>";
                                    echo "<td>".$trip->id."</td>";
                                    echo "<td>".$trip->name."</td>";
                                    if ($trip->status == 0) {
                                        echo "<td>Incomplete Boarding cards details</td>";
                                    }elseif ($trip->status == 1) {
                                        $card = App\BoardingCard::where('trip_id',$trip->id)->count();
                                        echo "<td>".$card." Cards Added Sort Now</td>";
                                    }
                                    echo "<td><a href='../".$trip->id."'>Enter Details</a></td>";
                                    echo "<td><a href='#' onclick='get(".$trip->id.")'>Sort</a></td>";
                                    echo "</tr>";
                                }?>
                        </tbody>
                    </table>
                </div>
            </div>
            
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title"> Add Trips</h3>
                    </div>
                </div>
                <div class="panel panel-secondary">
                    <form method="post" action="">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="fdest">Trip Name:</label>
                        <div class="col-sm-3"> 
                          <input type="text" class="form-control" name="TripName" id="fdest" placeholder="Enter Final Destination" required>
                        </div>
                      </div>
                       <div class="form-group"> 
                          <button type="submit" class="btn btn-default">Add Trip</button>
                          </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title"> Your Sorted trip</h3>
                    </div>
                </div>
                <div class="panel panel-secondary">
                    <ol id='list'>
                       
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
   
            
            function get(a) {
                //     $.getJSON("http://127.0.0.1:8000/api/sort_api/" + a).success(function(data){
                //     console.log(data); // will contain all data (and display it in console)
                // });
                
                    $.ajax({
                      type: 'GET',
                      url: "http://127.0.0.1:8000/api/sort_api/"+a+"/web",
                      contentType: 'application/json',
                      dataType: 'json', //specify jsonp
                      success: function(data) {
                         var htmlData= '';
                         for(var i=0; i<data.List.length; i++){
                            htmlData+= '<li>'+data.List[i]+' </li>';
                         }
                         $('#list').html(htmlData);
                         // 
                            // alert(data.List.length);
                         console.log(data);
                      }.bind(this),
                      error: function(e) {
                         console.log('error', e);
                      }
                    });            
                }

                //  $.getJSON("http://www.imdbapi.com/?" + dataString + "&callback=?").success(function(data){
                //     console.log(data); // will contain all data (and display it in console)
                // });

    </script>