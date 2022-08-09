<div class="modal fade" id="mPriceTable" role="dialog">
  <div class="modal-dialog">
    <?php echo form_open(admin_url('simulators/price_table'), array('id'=>'price-table-form')); ?>
    <div class="modal-content">
      <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">
              <span class="edit-title"><?php echo _l('simulator_rate_edit'); ?></span>
              <span class="add-title"><?php echo _l('simulator_rate_new'); ?></span>
          </h4>
      </div>
      <div class="modal-body">
          <div class="row">
            <div class="form-group select-placeholder col-md-6">
            	<?php
               	$selected = (isset($rate) ? $rate->rate : '');
               	echo render_select('rate',$rate,array('id','descripcion'),'simulator_rates',$selected);
               ?>
            </div>
            <div class="form-group select-placeholder col-md-6">
            	<?php
               	$selected = (isset($rate) ? $rate->hiredpotency : '');
               	echo render_select('hiredpotency',$hiredpotency,array('id','detalle'),'simulator_hired_potency',$selected);
               ?>
            </div>
          </div>
          <div class="row">
              <div class="col-md-4">
                  <div id="additional"></div>
                  <?php echo render_input('columnprice1', 'simulator_price_1','','number',['step'=>'0.000001','onkeypress'=>'return val_numbers(event);']); ?>
              </div>
              <div class="col-md-4">
                  <div id="additional"></div>
                  <?php echo render_input('columnprice2', 'simulator_price_2','','number',['step'=>'0.000001','onkeypress'=>'return val_numbers(event);']); ?>
              </div>
              <div class="col-md-4">
                  <div id="additional"></div>
                  <?php echo render_input('columnprice3', 'simulator_price_3','','number',['step'=>'0.000001','onkeypress'=>'return val_numbers(event);']); ?>
              </div>
          </div>
          <div class="row">
              <div class="col-md-4">
                  <div id="additional"></div>
                  <?php echo render_input('columnprice4', 'simulator_price_4','','number',['step'=>'0.000001','onkeypress'=>'return val_numbers(event);']); ?>
              </div>
              <div class="col-md-4">
                  <div id="additional"></div>
                  <?php echo render_input('columnprice5', 'simulator_price_5','','number',['step'=>'0.000001','onkeypress'=>'return val_numbers(event);']); ?>
              </div>
              <div class="col-md-4">
                  <div id="additional"></div>
                  <?php echo render_input('columnprice6', 'simulator_price_6','','number',['step'=>'0.000001','onkeypress'=>'return val_numbers(event);']); ?>
              </div>
          </div>
      </div>
      <div class="modal-footer">
        <div class="row">
          <div class="col-md-2"><input id="headpricetable" name="headpricetable" class="form-control hidden" type="number"></div>
          <div class="col-md-2"><input id="marketer1" name="marketer" class="form-control hidden" type="number"></div>
      	</div>
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo _l('close'); ?></button>
        <button type="submit" class="btn btn-info"><?php echo _l('submit'); ?></button>
      </div>
    </div><!-- /.modal-content -->
    <?php echo form_close(); ?>
    <input id="adminurl"class="hidden" type="text" value="<?php echo admin_url(); ?>">
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<script>

  window.addEventListener('load', function() {
    _validate_form($('#price-table-form'), {	
    	rate:'required',
    	hiredpotency:'required'
    }, manage_price_table);
    
    $('#mPriceTable').on('hidden.bs.modal', function(event) {
      $('#additional').html('');
      $('#mPriceTable input[name="rate"]').val('');
      $('#mPriceTable input[name="hiredpotency"]').val('');
      $('#mPriceTable input[name="columnprice1"]').val('');
      $('#mPriceTable input[name="columnprice2"]').val('');
      $('#mPriceTable input[name="columnprice3"]').val('');
      $('#mPriceTable input[name="columnprice4"]').val('');
      $('#mPriceTable input[name="columnprice5"]').val('');
      $('#mPriceTable input[name="columnprice6"]').val('');
      
      $('.add-title').removeClass('hide');
      $('.edit-title').removeClass('hide');
    });
  });
  
  function manage_price_table(form) {
    var data = $(form).serialize();
    var url = form.action;
    $.post(url, data).done(function(response) {
      response = JSON.parse(response);
      if(response.success == true) {
        alert_float('success',response.message);
      }
      if($.fn.DataTable.isDataTable('.table-price-table')) {
        $('.table-price-table').DataTable().ajax.reload();
      }
      $('#mPriceTable').modal('hide');
    });
    return false;
	}
	
	function new_price_table() {
		var marketer = $('#marketer option:selected').val();
		if (marketer == "") {
			alert_float('success',"Seleccione un comercializador");	
			$('#marketer').focus();
			event.target.selectedIndex = 0;
			return false;
		}
		
		var ids = $('#price_table option:selected').val();
		if (ids == "") {
			alert_float('success',"Seleccione una tabla de precios");	
			$('#price_table').focus();
			return false;
		}
		
		var headpricetable = ids.split('-')[0];
		$('#headpricetable').val(headpricetable);
		$('#marketer1').val(marketer);
    $('#mPriceTable input[name="rate"]').val('');
    $('#mPriceTable input[name="columnprice1"]').val('0');
    $('#mPriceTable input[name="columnprice2"]').val('0');
    $('#mPriceTable input[name="columnprice3"]').val('0');
    $('#mPriceTable input[name="columnprice4"]').val('0');
    $('#mPriceTable input[name="columnprice5"]').val('0');
    $('#mPriceTable input[name="columnprice6"]').val('0');
    
    var finished = $('#finished').val();
    if (finished == 3 || finished == 4) {
	    $('#mPriceTable input[name="columnprice2"]').attr('readonly', true);
	    $('#mPriceTable input[name="columnprice3"]').attr('readonly', true);
	    $('#mPriceTable input[name="columnprice4"]').attr('readonly', true);
	    $('#mPriceTable input[name="columnprice5"]').attr('readonly', true);
	    $('#mPriceTable input[name="columnprice6"]').attr('readonly', true);
		}
    
    $('#mPriceTable').modal('show');
    $('.edit-title').addClass('hide');
	}
	
	function edit_prices(invoker,id) {
		var url = $('#adminurl').val()+'simulators/get_price_table/'+id;
  	$.post(url).done(function (response) {
  		response = JSON.parse(response);
  		
  		$('#additional').append(hidden_input('id',id));
	    $('#rate').val(response.rate);
			var sRate = $('#rate');
			sRate.selectpicker('refresh');
	    $('#hiredpotency').val(response.hiredpotency);
			var sHiredpotency = $('#hiredpotency');
			sHiredpotency.selectpicker('refresh');
			
	    $('#mPriceTable input[name="columnprice1"]').val(response.columnprice1);
	    $('#mPriceTable input[name="columnprice2"]').val(response.columnprice2);
	    $('#mPriceTable input[name="columnprice3"]').val(response.columnprice3);
	    $('#mPriceTable input[name="columnprice4"]').val(response.columnprice4);
	    $('#mPriceTable input[name="columnprice5"]').val(response.columnprice5);
	    $('#mPriceTable input[name="columnprice6"]').val(response.columnprice6);
	    $('#headpricetable').val(response.headpricetable);
	    
	    $('#mPriceTable').modal('show');
	    $('.add-title').addClass('hide');
		});
	}
	
	///// Valida solo numeros.
	function val_numbers(eve) {
		var cod = 0;
		if (decimal_separator==',') cod = 44;
		if (decimal_separator=='.') cod = 46;
    var keynum = window.event ? window.event.keyCode : eve.which;
    if ((keynum == 8) || (keynum == cod)) return true;
    
    return /\d/.test(String.fromCharCode(keynum));
	}
	
</script>
