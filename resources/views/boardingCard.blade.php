<link href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/jquery.js"></script>
<!-- Include the above in your HEAD tag -->

<div class="container">
    <h1><a href="../"> Trip Sorter </a><small>(<i class="glyphicon glyphicon-filter"></i>)</small></h1>
        

        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                    <div class="row">
                        <div class="col-md-4 text-left panel-title"><h4> Add Boarding Card Data for Trip {{$name}}</h4></div>
                          <?php 
                          if ($card > 0) {
                            echo '<div class="col-md-8 text-right"><h4>Total Cards Added for Trip '.$name.': '.$card.'</h4></div>';
                          }?>
        </div>
                        
                        
                    </div>
                </div>
                  
                    <form method="post" action="">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="tripID" value="{{$tripID}}">

                    <div class="form-group">
                        <label class="control-label col-sm-12" for="Tname">Boarding Card Name:</label>
                        <div class="col-sm-4"> 
                          <input type="text" class="form-control" name="CardName" id="ddest" placeholder="Enter Card Name" required>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-sm-12" for="Tname">Transportation Type:</label>
                        <div class="col-sm-4"> 
                          <select name="trans_type" id="trans_type" class="form-control" required>
                            <option disabled selected value>Tansport Type</option>
                            <option value="Bus">Bus</option>
                            <option value="Train">Train</option>
                            <option value="AirLine">AirLine</option>
                          </select>

                        </div>
                      </div>
                    <div class="form-group">
                        <label class="control-label col-sm-12" for="ddest">Transport Name:</label>
                        <div class="col-sm-4"> 
                          <input type="text" class="form-control" name="Trans_name" id="ddest" placeholder="i.e Flight/Bus/Train Name" required>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-sm-12" for="fdest">Departure:</label>
                        <div class="col-sm-4"> 
                          <input type="text" class="form-control" name="D_dest" id="fdest" placeholder="Departure mentioned on card" required>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-sm-12" for="fdest">Arrival Destination:</label>
                        <div class="col-sm-4"> 
                          <input type="text" class="form-control" name="A_dest" id="fdest" placeholder="Arrival mentioned on card" required>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-sm-12" id="LGateNo" for="Gateno">Gate No:</label>
                        <div class="col-sm-4"> 
                          <input type="text" class="form-control" name="Gateno" id="Gateno" placeholder="Enter Gate No (Optional)">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-sm-12" id="LSeatNo" for="Sno">Seat No:</label>
                        <div class="col-sm-4"> 
                          <input type="text" class="form-control" name="Seatno" id="Seatno" placeholder="Enter Seat No (Optional)">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-sm-12" id="LBaggNo" for="BaggNo">Baggage Drop counter No:</label>
                        <div class="col-sm-4"> 
                          <input type="text" class="form-control" name="BaggNo" id="BaggNo" placeholder="Enter Baggage Drop counter No (Optional)"><br> 
                        </div>
                      </div>
                      <div class="form-group"> 
                      <div class="col-sm-12">
                          <button type="submit" class="btn btn-default" style="background-color: #428bca !important;color: #fff" name="submit">Add Boarding Card</button>
                          </div>
                          </div>
                    </form>
                    
            </div>
        </div>
    </div>
    
<script type="text/javascript">

var Privileges = jQuery('#trans_type');
var select = this.value;
Privileges.change(function () {
    if ($(this).val() == 'N/A') {
        $('#Gateno').hide();
        $('#LGateNo').hide();
        $('#BaggNo').hide();
        $('#LBaggNo').hide();
        $('#Seatno').hide();
        $('#LSeatNo').hide();
    }
    if ($(this).val() == 'Train') {
        $('#Gateno').hide();
        $('#LGateNo').hide();
        $('#BaggNo').hide();
        $('#LBaggNo').hide();
        $('#Seatno').show();
        $('#LSeatNo').show();
    }
    if ($(this).val() == 'Bus') {
        $('#Gateno').hide();
        $('#LGateNo').hide();
        $('#BaggNo').hide();
        $('#LBaggNo').hide();
        $('#Seatno').hide();
        $('#LSeatNo').hide();

    }if ($(this).val() == 'AirLine') {
        $('#Gateno').show();
        $('#LGateNo').show();
        $('#BaggNo').show();
        $('#LBaggNo').show();
        $('#Seatno').show();
        $('#LSeatNo').show();

    }
    });

</script>