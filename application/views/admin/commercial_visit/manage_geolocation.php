<?php init_head(); ?>
<div id="wrapper">
  <div class="content">
    <div class="row">
      <div class="col-md-12">
        <?php if(has_permission('commissions','','create')) { ?>
	      	<div class="panel_s">
	      		<div class="panel-body _buttons">
	      			<div class="col-md-12">
	      				<div class="row">
			            <?php echo form_open(admin_url('commissions'), array('id'=>'filtrar-form')); ?>
                  <div class="form-group select-placeholder col-md-4">
                    <?php echo render_select_with_input_group('cliente_id',$clients,array('id','nombre'),'clients'); ?>
                  </div>
                  <div class="form-group col-md-2">
                    <?php echo render_input('latitude', 'customer_latitude',$value,"text"); ?>
                  </div>
                  <div class="form-group col-md-2">
                    <?php echo render_input('length', 'customer_longitude',$value); ?>
                  </div>
                  <div class="col-md-1" style="padding-top: 7px;">
                    <br />
                    <button type="submit" class="btn btn-info filter"><?php echo _l('commercials_visits_geolocate'); ?></button>
                  </div>
                  <input id="contracts" name="contracts" class="hidden" type="text">
			            <?php echo form_close(); ?>
			            <input id="adminurl" class="hidden" type="text" value="<?php echo admin_url(); ?>">
		            </div>
	            </div>
	      		</div>
					</div>
				<?php } ?>
        <div class="panel_s">
          <div class="panel-body">
            <script src="https://maps.google.com/maps/api/js?sensor=falsekey=AIzaSyAix76c_nVSeEInvFBa0bsrhEAGHhWEBBU" type="text/javascript"></script>
            <div id="map" style="width:700px;height:500px;"></div>
            <script type="text/javascript">
              var latlng = new google.maps.LatLng(42.1623201, -8.6222419);
 
              // definimos valor por defecto
              var myOptions = {
                zoom: 14,
                center: latlng,
                mapTypeId: google.maps.MapTypeId.ROADMAP
              };

              // generamos el mapa
              var map = new google.maps.Map(document.getElementById("map"), myOptions);              
              
              // añadimos una marca
              var marker = new google.maps.Marker({
                  position: latlng,
                  title: 'Ingegria Energia',
                  draggable: true
              });

              marker.setMap(map);
              var popup = new google.maps.InfoWindow({
                  content: 'Ingegria Energia',
                  position: latlng
              });
              
              popup.open(map);
            </script>
         	</div>
       	</div>
   		</div>
    </div>
	</div>
</div>
<?php init_tail(); ?>
<script>
   
  $(function() {
    var ContractsServerParams = {};
    
    $.each($('._hidden_inputs._filters input'),function() {
        ContractsServerParams[$(this).attr('name')] = '[name="'+$(this).attr('name')+'"]';
    });
    initDataTable('.table-contracts', admin_url+'commissions/table', undefined, undefined, ContractsServerParams,<?php echo do_action('contracts_table_default_order',json_encode(array(6,'asc'))); ?>);

    new Chart($('#contracts-by-type-chart'), {
      type: 'bar',
      data: <?php echo $chart_types; ?>,
      options: {
        legend: {
          display: false,
        },
        responsive: true,
        maintainAspectRatio:false,
        scales: {
          yAxes: [{
            display: true,
            ticks: {
              suggestedMin: 0,
            }
          }]
        }
      }
    });
    
    new Chart($('#contracts-value-by-type-chart'), {
      type: 'line',
      data: <?php echo $chart_types_values; ?>,
      options: {
        responsive: true,
        legend: {
          display: false,
        },
        maintainAspectRatio:false,
        scales: {
          yAxes: [{
            display: true,
            ticks: {
              suggestedMin: 0,
            }
          }]
        }
      }
    });
        
  });
  
  $(".chk_id_all").change(function () {
  	$(".chk_id").attr('checked', this.checked);
  });
  
  $(".invoice").click(function() {
		var contracts = [];
		
    $('.chk_id').each(function() {
      if (this.checked) contracts.push($(this).val());
    });
		if (contracts.length == 0) {
			alert_float('success',"Seleccione contratos a facturar");	
			return false;
		}
  	$('#contracts').val(contracts);
  	var url = $('#adminurl').val()+'invoices/invoice';
  	
  	$("#filtrar-form").attr('action',url);
  	$("#filtrar-form").submit();
  });
  
  function invoice(url) {
		var contracts = [];
		
    $('.chk_id').each(function() {
      if (this.checked) contracts.push($(this).val());
    });
    
		if (contracts.length == 0) {
			alert_float('success',"Seleccione contratos a facturar");	
			return false;
		}
		
    var data = {
    	'fdesde' 		: $('#fdesde').val(),
    	'fhasta' 		: $('#fhasta').val(),
    	'cliente'		: $('#cliente').val(),
    	'contracts' : contracts
    }
    
    $.post(url, data).done(function(response) {
      response = JSON.parse(response);
      console.log(response);
    }).fail(function(data) {
      var error = JSON.parse(data.responseText);
      alert_float('danger',error.message);
    });
    
    return false;
	}
	
	///// Cuando selecciona un cliente.
	$('#cliente').change(function(Event) {
		var id =  $('#clientid option:selected').val();
		if (id != '') {
			$('.filter').removeAttr('disabled');
    }
	});
	
</script>
</body>
</html>
