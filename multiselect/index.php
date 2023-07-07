
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
  
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/css/bootstrap-multiselect.css" />


<br><br>
  
   <form method="post" id="prim_skills_form">
  
     <label>Select Skills</label>
     <select id="prim_skills" name="prim_skills[]" multiple >
      <option value="java">java</option>
      <option value="Php">Php</option>
      <option value="Python">Python</option>
      <option value="Angular">Angular</option>
      <option value="Java Script">Java Script</option>
      <option value="Css">Css</option>
      <option value="React">React</option>
      <option value=".Net">.Net</option>
     </select>
  


     <input type="submit" class="btn btn-info" name="submit" value="Submit" />


   </form>


<script>
$(document).ready(function(){
 $('#prim_skills').multiselect({
  nonSelectedText: 'Select Your Skills',
  enableFiltering: true,
  enableCaseInsensitiveFiltering: true,
  buttonWidth:'400px'
 });
 
 $('#prim_skills_form').on('submit', function(event){
  event.preventDefault();
  var form_data = $(this).serialize();
  $.ajax({
   url:"insert.php",
   method:"POST",
   data:form_data,
   success:function(data)
   {
    $('#prim_skills option:selected').each(function(){
     $(this).prop('selected', false);
    });
    $('#prim_skills').multiselect('refresh');
    alert(data);
   }
  });
 });
 
 
});
</script>