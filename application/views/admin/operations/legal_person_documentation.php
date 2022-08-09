<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="col-md-12 text-center" style="color: #0099ff">
  <h4><strong>DOCUMENTACION NECESARIA PARA EL ESTUDIO DE PRESTAMO</strong></h4>
  <h4><strong>(TRABAJADORES POR CUENTA AJENA)</strong></h4>
  <h5><strong style="color: #000">Check List</strong></h5>
  <hr class="hr-panel-heading" />
</div>

<?php if (count($documents)>0) $action = admin_url("operations/documents_necessary/" . $operation->id); 
        else $action = admin_url("operations/documents_necessary"); ?>
<?php echo form_open($action,array('id'=>'documents-physical-form','enctype'=>'multipart/form-data')); ?>
  <div class="col-md-12">
    <div class="form-group row">
      <?php if (isset($documents)) (($documents[0]['exist']==0) ? $value='' : $value=' checked'); else $value=''; ?>
      <div class="col-md-1"><label><input name="exist[]" type="checkbox" value="1"<?php echo $value; ?>> 01. </label></div>
      <div class="col-md-6">
        <label>FOTOCOPIA EN COLOR DE DNI / NIE / CARTA VERDE (EUROPEOS)</label>
        <input type="hidden" class="form-control" name="name[]" value="FOTOCOPIA EN COLOR DE DNI / NIE / CARTA VERDE (EUROPEOS)">
        <input type="hidden" class="form-control" name="number[]" value="1">
        <?php if (isset($documents)) if ($documents[0]['exist']==1) echo ('<p><a href="' . $documents[0]['file'] . '" target="_blank">' . $documents[0]['name'] . "</a></p>"); ?>
      </div>
      <div class="col-md-5"><input type="file" name="file[]" style="border: none;"></div>
    </div>
  
    <div class="form-group row">
      <?php if (isset($documents)) (($documents[1]['exist']==0) ? $value='' : $value=' checked'); else $value=''; ?>
      <div class="col-md-1"><label><input name="exist[]" type="checkbox" value="2"<?php echo $value; ?>> 02. </label></div>
      <div class="col-md-6">
        <label>AUTORIZACIONES CIRBE Y PROTECCIÓN DE DATOS FIRMADAS</label>
        <input type="hidden" class="form-control" name="name[]" value="AUTORIZACIONES CIRBE Y PROTECCIÓN DE DATOS FIRMADAS">
        <input type="hidden" class="form-control" name="number[]" value="2">
        <?php if (isset($documents)) if ($documents[1]['exist']==1) echo ('<p><a href="' . $documents[1]['file'] . '" target="_blank">' . $documents[1]['name'] . "</a></p>"); ?>
      </div>
      <div class="col-md-5"><input type="file" name="file[]" style="border: none;"></div>
    </div>
  
    <div class="form-group row">
      <?php if (isset($documents)) (($documents[2]['exist']==0) ? $value='' : $value=' checked'); else $value=''; ?>
      <div class="col-md-1"><label><input name="exist[]" type="checkbox" value="3"<?php echo $value; ?>> 03. </label></div>
      <div class="col-md-6">
        <label>VIDA LABORAL ACTUALIZADA</label>
        <input type="hidden" class="form-control" name="name[]" value="VIDA LABORAL ACTUALIZADA">
        <input type="hidden" class="form-control" name="number[]" value="3">
        <?php if (isset($documents)) if ($documents[2]['exist']==1) echo ('<p><a href="' . $documents[2]['file'] . '" target="_blank">' . $documents[2]['name'] . "</a></p>"); ?>
      </div>
      <div class="col-md-5"><input type="file" name="file[]" style="border: none;"></div>
    </div>
  
    <div class="form-group row">
      <?php if (isset($documents)) (($documents[3]['exist']==0) ? $value='' : $value=' checked'); else $value=''; ?>
      <div class="col-md-1"><label><input name="exist[]" type="checkbox" value="4"<?php echo $value; ?>> 04. </label></div>
      <div class="col-md-6">
        <label>CONTRATO DE TRABAJO</label>
        <input type="hidden" class="form-control" name="name[]" value="CONTRATO DE TRABAJO">
        <input type="hidden" class="form-control" name="number[]" value="4">
        <?php if (isset($documents)) if ($documents[3]['exist']==1) echo ('<p><a href="' . $documents[3]['file'] . '" target="_blank">' . $documents[3]['name'] . "</a></p>"); ?>
      </div>
      <div class="col-md-5"><input type="file" name="file[]" style="border: none;"></div>
    </div>
  
    <div class="form-group row">
      <?php if (isset($documents)) (($documents[4]['exist']==0) ? $value='' : $value=' checked'); else $value=''; ?>
      <div class="col-md-1"><label><input name="exist[]" type="checkbox" value="5"<?php echo $value; ?>> 05. </label></div>
      <div class="col-md-6">
        <label>3 ÚLTIMAS NÓMINAS</label>
        <input type="hidden" class="form-control" name="name[]" value="3 ÚLTIMAS NÓMINAS">
        <input type="hidden" class="form-control" name="number[]" value="5">
        <?php if (isset($documents)) if ($documents[4]['exist']==1) echo ('<p><a href="' . $documents[4]['file'] . '" target="_blank">' . $documents[4]['name'] . "</a></p>"); ?>
      </div>
      <div class="col-md-5"><input type="file" name="file[]" style="border: none;"></div>
    </div>
  
    <div class="form-group row">
      <?php if (isset($documents)) (($documents[5]['exist']==0) ? $value='' : $value=' checked'); else $value=''; ?>
      <div class="col-md-1"><label><input name="exist[]" type="checkbox" value="6"<?php echo $value; ?>> 06. </label></div>
      <div class="col-md-6">
        <label>ULTIMA DECLARACIÓN DE LA RENTA O CERTIFICADO RETENCIONES</label>
        <input type="hidden" class="form-control" name="name[]" value="ULTIMA DECLARACIÓN DE LA RENTA O CERTIFICADO RETENCIONES">
        <input type="hidden" class="form-control" name="number[]" value="6">
        <?php if (isset($documents)) if ($documents[5]['exist']==1) echo ('<p><a href="' . $documents[5]['file'] . '" target="_blank">' . $documents[5]['name'] . "</a></p>"); ?>
      </div>
      <div class="col-md-5"><input type="file" name="file[]" style="border: none;"></div>
    </div>
  
    <div class="form-group row">
      <?php if (isset($documents)) (($documents[6]['exist']==0) ? $value='' : $value=' checked'); else $value=''; ?>
      <div class="col-md-1"><label><input name="exist[]" type="checkbox" value="7"<?php echo $value; ?>> 07. </label></div>
      <div class="col-md-6">
        <label>MOVIMIENTOS DE TODAS LAS CUENTAS QUE TENGA DE LOS 6 ULTIMOS MESES (CARÁTULA Y MOVIMIENTOS)</label>
        <input type="hidden" class="form-control" name="name[]" value="MOVIMIENTOS DE TODAS LAS CUENTAS QUE TENGA DE LOS 6 ULTIMOS MESES (CARÁTULA Y MOVIMIENTOS)">
        <input type="hidden" class="form-control" name="number[]" value="7">
        <?php if (isset($documents)) if ($documents[6]['exist']==1) echo ('<p><a href="' . $documents[6]['file'] . '" target="_blank">' . $documents[6]['name'] . "</a></p>"); ?>
      </div>
      <div class="col-md-5"><input type="file" name="file[]" style="border: none;"></div>
    </div>

    <div class="form-group row">
      <?php if (isset($documents)) (($documents[7]['exist']==0) ? $value='' : $value=' checked'); else $value=''; ?>
      <div class="col-md-1"><label><input name="exist[]" type="checkbox" value="8"<?php echo $value; ?>> 08. </label></div>
      <div class="col-md-6">
        <label>3 ÚLTIMOS RECIBOS DE TODOS LOS PRÉSTAMOS/FINANCIACIONES (SI ES TITULAR DE ALGUNO)</label>
        <input type="hidden" class="form-control" name="name[]" value="3 ÚLTIMOS RECIBOS DE TODOS LOS PRÉSTAMOS/FINANCIACIONES (SI ES TITULAR DE ALGUNO)">
        <input type="hidden" class="form-control" name="number[]" value="8">
        <?php if (isset($documents)) if ($documents[7]['exist']==1) echo ('<p><a href="' . $documents[7]['file'] . '" target="_blank">' . $documents[7]['name'] . "</a></p>"); ?>
      </div>
      <div class="col-md-5"><input type="file" name="file[]" style="border: none;"></div>
    </div>

    <div class="form-group row">
      <?php if (isset($documents)) (($documents[8]['exist']==0) ? $value='' : $value=' checked'); else $value=''; ?>
      <div class="col-md-1"><label><input name="exist[]" type="checkbox" value="9"<?php echo $value; ?>> 09. </label></div>
      <div class="col-md-6">
        <label>CONTRATO DE ALQUILER Y 3 ULTIMOS RECIBOS (SI VIVE DE ALQUILER)</label>
        <input type="hidden" class="form-control" name="name[]" value="CONTRATO DE ALQUILER Y 3 ULTIMOS RECIBOS (SI VIVE DE ALQUILER)">
        <input type="hidden" class="form-control" name="number[]" value="9">
        <?php if (isset($documents)) if ($documents[8]['exist']==1) echo ('<p><a href="' . $documents[8]['file'] . '" target="_blank">' . $documents[8]['name'] . "</a></p>"); ?>
      </div>
      <div class="col-md-5"><input type="file" name="file[]" style="border: none;"></div>
    </div>

    <div class="form-group row">
      <?php if (isset($documents)) (($documents[9]['exist']==0) ? $value='' : $value=' checked'); else $value=''; ?>
      <div class="col-md-1"><label><input name="exist[]" type="checkbox" value="10"<?php echo $value; ?>> 10. </label></div>
      <div class="col-md-6">
        <label>CONTRATO DE ARRAS (EN CASO DE COMPRA-VENTAS)</label>
        <input type="hidden" class="form-control" name="name[]" value="CONTRATO DE ARRAS (EN CASO DE COMPRA-VENTAS)">
        <input type="hidden" class="form-control" name="number[]" value="10">
        <?php if (isset($documents)) if ($documents[9]['exist']==1) echo ('<p><a href="' . $documents[9]['file'] . '" target="_blank">' . $documents[9]['name'] . "</a></p>"); ?>
      </div>
      <div class="col-md-5"><input type="file" name="file[]" style="border: none;"></div>
    </div>
    
    <div class="form-group row">
      <?php if (isset($documents)) (($documents[10]['exist']==0) ? $value='' : $value=' checked'); else $value=''; ?>
      <div class="col-md-1"><label><input name="exist[]" type="checkbox" value="11"<?php echo $value; ?>> 11. </label></div>
      <div class="col-md-6">
        <label>NOTA SIMPLE (DE LA FINCA A HIPOTECAR)</label>
        <input type="hidden" class="form-control" name="name[]" value="NOTA SIMPLE (DE LA FINCA A HIPOTECAR)">
        <input type="hidden" class="form-control" name="number[]" value="11">
        <?php if (isset($documents)) if ($documents[10]['exist']==1) echo ('<p><a href="' . $documents[10]['file'] . '" target="_blank">' . $documents[10]['name'] . "</a></p>"); ?>
      </div>
      <div class="col-md-5"><input type="file" name="file[]" style="border: none;"></div>
    </div>

    <div class="form-group row">
      <?php if (isset($documents)) (($documents[11]['exist']==0) ? $value='' : $value=' checked'); else $value=''; ?>
      <div class="col-md-1"><label><input name="exist[]" type="checkbox" value="12"<?php echo $value; ?>> 12. </label></div>
      <div class="col-md-6">
        <label>FOTOCOPIA DE LAS ESCRITURAS DE LA FINCA</label>
        <input type="hidden" class="form-control" name="name[]" value="FOTOCOPIA DE LAS ESCRITURAS DE LA FINCA">
        <input type="hidden" class="form-control" name="number[]" value="12">
        <?php if (isset($documents)) if ($documents[11]['exist']==1) echo ('<p><a href="' . $documents[11]['file'] . '" target="_blank">' . $documents[11]['name'] . "</a></p>"); ?>
      </div>
      <div class="col-md-5"><input type="file" name="file[]" style="border: none;"></div>
    </div>
    
    <div class="form-group row">
      <?php if (isset($documents)) (($documents[12]['exist']==0) ? $value='' : $value=' checked'); else $value=''; ?>
      <div class="col-md-1"><label><input name="exist[]" type="checkbox" value="13"<?php echo $value; ?>> 13. </label></div>
      <div class="col-md-6">
        <label>EN CASO DE ESTAR CASADO/A EN SEPARACIÓN DE BIENES: FOTOCOPIA DE LAS CAPITULACIONES MATRIMONIALES</label>
        <input type="hidden" class="form-control" name="name[]" value="EN CASO DE ESTAR CASADO/A EN SEPARACIÓN DE BIENES: FOTOCOPIA DE LAS CAPITULACIONES MATRIMONIALES">
        <input type="hidden" class="form-control" name="number[]" value="13">
        <?php if (isset($documents)) if ($documents[12]['exist']==1) echo ('<p><a href="' . $documents[12]['file'] . '" target="_blank">' . $documents[12]['name'] . "</a></p>"); ?>
      </div>
      <div class="col-md-5"><input type="file" name="file[]" style="border: none;"></div>
    </div>
    
    <div class="row text-center">
      <input type="hidden" class="form-control" name="visit" value="<?php echo $operation->id; ?>">
      <input type="hidden" class="form-control" name="type" value="<?php echo $operation->type_id; ?>">
      <hr class="hr-panel-heading" />
      <button type="submit" class="btn btn-primary">Enviar</button>
    </div>
  </div>
<?php echo form_close(); ?>
