<form class="form" name="add_patient_family_form" data-toggle="validator" onsubmit="return add_patient_family(this)">
		<?php if(isset($bmi) && is_array($bmi) && sizeof($bmi)>0){?>
      <table class="table table-condensed table-bordered table-striped">
      <tr>
      <td align="center">Weight</td>
      <td align="center">Height</td>
      <td align="center">BMI</td>
      </tr>
      <?php foreach($bmi as $bkey=>$bval){?>
      <tr>
      <td align="center"><?=$bval->weight ?></td>
      <td align="center"><?=$bval->height_feet.".".$bval->height_inches ?></td>
      <td align="center"><?=$bval->bmi_value ?></td>
      </tr>
      <?php }?>
      </table>															  
    <?php } ?>
    <div class="form-group">
      <label for="weight" class="control-label">Weight in Kilograms</label>
      <input name="weight" style="width:25%" type="text" class="form-control" id="weight" value="" />    
    </div>
    <div class="form-group form-inline">
      <label class="control-label" for="height_feet">Height in Ft & In</label>
      <input name="height_feet" type="text" class="form-control" id="height_feet" value="" Placeholder="Feet"/>
      <input name="height_inches" type="text" class="form-control" placeholder="Inches" id="height_inches" value="" />
      <input type="button" class="btn btn-primary" onclick="calculatebmi()"  value="Calculate BMI" />
    </div>
    <div class="form-group">
      <label class="control-label">BMI</label>
      <input style="width:25%" name="bmi_value" type="text" class="form-control" id="bmi_value" value="" readonly />
    </div>
    <table class="table table-condensed table-bordered table-striped">
    <tr><td>BMI</td><td>Weight Status</td></tr>
    <tr><td>Below 18.5</td><td>Underweight</td></tr> 	
    <tr><td>18.5—24.9</td><td>Normal</td></tr>
    <tr><td>25.0—29.9</td><td>Overweight</td></tr> 	
    <tr><td>30.0 and Above</td><td>Obese</td></tr>
    </table>

    <div class="form-group form-inline">
      <label class="control-label" for="blood_group">Blood Group</label>
      <select name="blood_group" id="blood_group" class="form-control" >
        <option value="">Select Blood Group</option>
        <?php if(isset($blood_group) && sizeof($blood_group)>0){
        foreach($blood_group as $bKey=>$bVal){?>
          <option value="<?=$bVal->name ?>" 
          <?=(@$patientdetails->blood_group==$bVal->name)?'selected="selected"':'' ?>><?=$bVal->name?>
          </option>
        <?php }} ?>
      </select>
    </div>
    <div class="form-group">
      <label class="control-label">Food Habits</label>
      <div class="radio">
        <label class="control-label radio-inline" for="food_habit_veg">
        <input type="radio" name="food_habits" id="food_habit_veg" value="1" <?=(@$patientdetails->food_habits==1)?'checked':''?> required /> Veg
        </label>
        <label class="control-label radio-inline" for="food_habit_nonveg">
        <input type="radio" name="food_habits" id="food_habit_nonveg" value="2" <?=(@$patientdetails->food_habits==2)?'checked':''?> required/> Non-Veg
        </label>
      </div>
    </div>
    <div class="form-group">
      <label class="control-label">Alcohol</label>
      <div class="radio">
        <label class="control-label radio-inline" for="alcohol_frequent">
        <input type="radio" name="alcohol" id="alcohol_frequent" value="1" <?=(@$patientdetails->alcohol==1)?'checked':'' ?>  required /> Frequent
        </label>
        <label class="control-label radio-inline" for="alcohol_occasional">
        <input type="radio" name="alcohol" id="alcohol_occasional" value="2" <?=(@$patientdetails->alcohol==2)?'checked="checked"':'' ?> required /> Occasional
        </label>      
        <label class="control-label radio-inline" for="alcohol_rare">
        <input type="radio" name="alcohol" id="alcohol_rare" value="3" <?=(@$patientdetails->alcohol==3)?'checked':'' ?> required/> Rare
        </label>
        <label class="control-label radio-inline" for="alcohol_never">
        <input type="radio" name="alcohol" id="alcohol_never" value="4" <?=(@$patientdetails->alcohol==4)?'checked':'' ?> required/> Never
        </label>          
      </div>
    </div>
    <div class="form-group">
      <label class="control-label">Smoking</label>
      <div class="radio">
        <label class="control-label radio-inline" for="smoking_frequent">
        <input type="radio" name="smoking" id="smoking_frequent" value="1" <?=(@$patientdetails->alcohol==1)?'checked':'' ?>   required/> Frequent
        </label>
        <label class="control-label radio-inline" for="smoking_occasional">
        <input type="radio" name="smoking" id="smoking_occasional" value="2" <?=(@$patientdetails->alcohol==2)?'checked="checked"':'' ?> required /> Occasional
        </label>
        <label class="control-label radio-inline" for="smoking_rare">
        <input type="radio" name="smoking" id="smoking_rare" value="3" <?=(@$patientdetails->alcohol==3)?'checked':'' ?> required/> Rare
        </label>
        <label class="control-label radio-inline" for="smoking_never">
        <input type="radio" name="smoking" id="smoking_never" value="4" <?=(@$patientdetails->alcohol==4)?'checked':'' ?> required/> Never
        </label>
      </div>
    </div>
    <div class="form-group">
      <label class="control-label" for="ciggi_per_day">No. of cigarettes per day</label>
      <input style="width:25%" name="no_of_cig" type="text" class="form-control" id="ciggi_per_day" value="<?=@$patientdetails->ciggi_per_day ?>" >
    </div>
    <div class="form-group ">
      <label class="control-label">Tobacco Consumption</label>
      <div class="radio">
        <label class="control-label radio-inline" for="tobacco_consumption_frequent">
        <input type="radio" name="tobacco" id="tobacco_consumption_frequent" value="1" <?=(@$patientdetails->alcohol==1)?'checked':'' ?> required/> Frequent
        </label>
        <label class="control-label radio-inline" for="tobacco_consumption_occasional">
        <input type="radio" name="tobacco" id="tobacco_consumption_occasional" value="2" <?=(@$patientdetails->alcohol==2)?'checked':'' ?> required/> Occasional
        </label>
        <label class="control-label radio-inline" for="tobacco_consumption_rare">
        <input type="radio" name="tobacco" id="tobacco_consumption_rare" value="3" <?=(@$patientdetails->alcohol==3)?'checked':'' ?> required/> Rare
        </label>
        <label class="control-label radio-inline" for="tobacco_consumption_never">
        <input type="radio" name="tobacco" id="tobacco_consumption_never" value="4" <?=(@$patientdetails->alcohol==4)?'checked':'' ?> required/> Never
        </label>
      </div>
    </div>
    <div class="form-group form-inline">
	    <input type="hidden" name="patient_id" id="patient_id" value="<?=$patient_id?>" /> 
      <input  type="submit" class="btn btn-success" value="Save"  >
    </div> 
</form>
<script type="text/javascript">
function add_patient_family(obj)
{
	var form_data	=	$(obj).serializeArray();
	var data	= [];
	
	$.each( form_data, function( i, field ) {
		data[field.name]	=	field.value;
	});
	console.log(data);
	if(data['patient_id'] && data['height_feet'] && data['height_inches'] && data['weight'] && data['bmi_value'])
	{
		$.ajax({
			url: '/api/doctor/add_patient_bmi',
			type: 'POST',
			data:{'patient_id':data['patient_id'],'height_feet':data['height_feet'],'height_inches':data['height_inches'],'weight':data['weight'],'bmi_value':data['bmi_value']},
			cache: false,
			dataType: 'json',
			beforeSend: function() {loading();},		
			success: function(resp){
				console.log(resp);
				if(resp.success){}
			},
			complete: function() {removeLoading();}
		});
	}
	
	//console.log(data['patient_id'] && data['blood_group'] && data['food_habits'] && data['alcohol'] && data['no_of_cig'] && data['smoking'] && data['tobacco']);
	if(data['patient_id'] && data['blood_group'] && data['food_habits'] && data['alcohol'] && data['smoking'] && data['tobacco'])
	{
		$.ajax({
			url: '/api/doctor/update_patient',
			type: 'POST',
			data:{'patient_id':data['patient_id'],'blood_group':data['blood_group'],'food_habits':data['food_habits'],'alcohol':data['alcohol'],'smoking':data['smoking'],'ciggi_per_day':data['no_of_cig'],'tobacco_consumption':data['tobacco']},
			cache: false,
			dataType: 'json',
			beforeSend: function() {loading();},
			success: function(resp){
				console.log(resp);
				if(resp.success){}
			},
			complete: function() {removeLoading();}
		});	
	}
	return false;
}
</script>