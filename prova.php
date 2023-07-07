<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css" rel="stylesheet" />




<div class="container">

  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <!-- /.box-header -->
        <div class="box-body">
          <form>
            <div class="form-group row">
              <label for="" class="col-sm-2 form-control-label">Person</label>
              <div class="col-sm-10">
                <select class="form-control selectpicker" id="select-person" data-live-search="true">
    
                <option data-tokens="tom foolery 55 tom 55">Tom Foolery 55</option>
                <option data-tokens="tom gordon 34 tom 34">Tom Gordon 34</option>
                <option data-tokens="elizabeth warren">Elizabeth Warren</option>
                <option data-tokens="mario flores">Mario Flores</option>
                <option data-tokens="don young">Don Young</option>
                </select>

              </div>
            </div>
          </form>
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->
    </div>
    <!-- /.col -->
  </div>
  <!-- /.row -->
</div>
<!-- /.container -->

<script>
$(function() {
$('.selectpicker').selectpicker('render');
});
</script>