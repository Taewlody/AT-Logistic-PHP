
<link href="css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css" rel="stylesheet">
<link href="css/plugins/select2/select2.min.css" rel="stylesheet">
<script>
            $(document).ready(function () {
				 //$(".chosen-select").select2();
				     $('.select2_single').select2({});
            });
        </script>

<div class="row wrapper border-bottom white-bg page-heading">
  <div class="col-lg-10">
    <h2>Messenger Booking</h2>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"> <a>Home</a></li>
      <li class="breadcrumb-item"> <a>Messenger</a></li>
      <li class="breadcrumb-item"> <a>Messenger booking</a> </li>
      <li class="breadcrumb-item"> <a>Messenger booking  Form</a></li>
    </ol>
  </div>
  <div class="col-lg-2"> </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight"> <!-- Body-->

    <div class="row">
    <div class="col-lg-12">
      <div class="ibox ">
        <div class="ibox-content">
          <form method="get">
			 <div class="form-group  row">
              <label class="col-sm-2 col-form-label">
              <h3>Booking  info</h3></label>
         
            </div>
			   <div class="hr-line-dashed"></div>
            <div class="form-group  row">
              <label class="col-sm-2 col-form-label">Document No.</label>
              <div class="col-md-2">
                <input type="text" name="cusCode" class="form-control">
              </div>
            </div>
            
        	 <div class="form-group  row">
          <label class="col-sm-2 col-form-label">Document Date</label>
          <div class="col-md-2">
       <div class="input-group date"> <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
              <input  type="text" class="form-control input-group date" value="03/04/2014"  >
            </div>
          </div>
        </div>

          <div class="form-group  row">
              <label class="col-sm-2 col-form-label"> Job Type</label>
              <div class="col-md-2">
           <select class="select2_single form-control select2">
                  <option value="1">วางบิล</option>
                  <option value="2">ส่งเอกสาร</option>
                </select>
              </div>
            </div>
            
			  
            <div class="form-group  row">
              <label class="col-sm-2 col-form-label">Messenger</label>
              <div class="col-md-2">
           <select class="select2_single form-control select2">
                  <option value="1">Select</option>
                  <option value="2">Select</option>
                </select>
              </div>
            </div>
			  

                
            <div class="form-group  row">
                                    <label class="col-sm-2 col-form-label">Detail</label>

                                    <div class="col-sm-10">  <textarea rows="4"  class="form-control"></textarea></div>
              </div>
           
            
     
            
            <div class="form-group row">
              <label class="col-sm-2 col-form-label">Status</label>
              <div class="col-sm-10">
                <label class="checkbox-inline i-checks">
                  <input type="radio" name="status" value="option1" checked>
                  Active </label>
                <label class="i-checks">
                  <input type="radio"  name="status" value="option2">
                  Inactive</label>
              </div>
            </div>
   	             <div class="form-group  row">
              <label class="col-sm-2 col-form-label">Create By</label>
              <div class="col-sm-10">
                 <label>admin  1/1/2021 : 03:12:20</label>
              </div>
            </div>
			  
           <div class="form-group  row">
              <label class="col-sm-2 col-form-label">Update By</label>
              <div class="col-sm-10">
               
				  <label>admin  1/1/2021 : 03:12:20</label>
              </div>
            </div>   
            
            <div class="hr-line-dashed"></div>
       
            <div class="form-group row">
              <div class="col-sm-4 col-sm-offset-2">
               <button class="btn btn-primary " type="submit"><i class="fa fa-save"></i> Save</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<!--  END Body-->