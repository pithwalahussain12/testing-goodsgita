	
	<div class="form-group">
		<label class="control-label">  Vailid From </label>
                <input type="text" class="form-control required " name="availFrom"   id="availFrom"  readonly>	
	</div>	

	<div class="form-group">
		<label class="control-label">  Expire Date </label>
			<input type="text" value="" class="form-control required " name="expireDate"   id="expireDate" readonly >			
	</div>	

<script>
var startDate = new Date();
var fechaFin = new Date();
var FromEndDate = new Date();
var ToEndDate = new Date();
$('#availFrom').datepicker({
    autoclose: true,
	startDate: startDate,
    format: 'yyyy-mm-dd'
}).on('changeDate', function(selected){
        startDate = new Date(selected.date.valueOf());
        startDate.setDate(startDate.getDate(new Date(selected.date.valueOf())));
        $('#expireDate').datepicker('setStartDate', startDate);
    }); 

$('#expireDate').datepicker({
    autoclose: true,
    format:'yyyy-mm-dd'
}).on('changeDate', function(selected){
        FromEndDate = new Date(selected.date.valueOf());
        FromEndDate.setDate(FromEndDate.getDate(new Date(selected.date.valueOf())));
        $('#availFrom').datepicker('setEndDate', FromEndDate);
    });
		
</script>
