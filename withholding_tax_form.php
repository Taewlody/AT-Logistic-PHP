<!-- Jasny -->
<script src="js/plugins/jasny/jasny-bootstrap.min.js"></script>

<link href="css/plugins/jasny/jasny-bootstrap.min.css" rel="stylesheet">

<!-- Data picker -->
<script src="js/plugins/datapicker/bootstrap-datepicker.js"></script>
<link href="css/plugins/datapicker/datepicker3.css" rel="stylesheet">

<!-- Clock picker -->
<script src="js/plugins/clockpicker/clockpicker.js"></script>
<link href="css/plugins/clockpicker/clockpicker.css" rel="stylesheet">
<script>
  $(document).ready(function() {

    $('.select2_single').select2({
      /*
       allowClear: true,
       placeholder: 'Select',    
         language: {
             noResults: function() {
            return `<button style="width: 100%" type="button" class="btn btn-primary"  onClick='task()'>+ Add New Item</button> </li>`;
            }
         },
       
        escapeMarkup: function (markup) {
            return markup;
        }
		*/
    });


    /*
$('.chosen-select').select2({
	    allowClear: true,
       placeholder: 'This is my placeholder',    
         language: {
             noResults: function() {
            return `<button style="width: 100%" type="button"
            class="btn btn-primary" 
            onClick='task()'>+ Add New Item</button>
            </li>`;
            }
         },
       
        escapeMarkup: function (markup) {
            return markup;
        },
width: "100%"
});
   		*/





    var mem = $('.date .input-group.date').datepicker({
      todayBtn: "linked",
      keyboardNavigation: false,
      forceParse: false,
      calendarWeeks: true,
      autoclose: true
    });

    $('.clockpicker').clockpicker();

  });
</script>

<div class="row wrapper border-bottom white-bg page-heading">
  <div class="col-lg-6">
    <h2>Withholding Tax / ใบหักภษี ณ ที่จ่าย</h2>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"> <a>Home</a></li>
      <li class="breadcrumb-item"> <a>Account</a></li>
      <li class="breadcrumb-item"> <a>Withholding Tax</a> </li>
      <li class="breadcrumb-item"> <a>Withholding Tax Form</a></li>
    </ol>
  </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
  <!-- Body-->

  <div class="row">
    <div class="col-lg-7">
      <div class="ibox ">
        <div class="ibox-title">
          <h2>Document</h2>
          <div class="ibox-tools"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></div>
        </div>
        <div class="ibox-content">
          <div class="form-group row">
            <label class="col-lg-2 col-form-label"><span class="col-form-label" style="padding-top: 5px;">Document</span> No.</label>
            <div class="col-md-4">
              <input type="text" name="cusCode" class="form-control">
            </div>
            <div class="col-md-2">
              <label class="col-form-label" style="padding-top: 5px;">Document Date</label>
            </div>
            <div class="col-lg-4">
              <div class="input-group date"> <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                <input type="text" class="form-control input-group date" value="03/04/2014">
              </div>
            </div>
          </div>
          <div class="form-group  row">
            <label class="col-sm-2 col-form-label">Name</label>
            <div class="col-md-10">
              <select class="select2_single form-control select2">
                <option value="1">Select</option>
              </select>
            </div>
          </div>
          <div class="form-group  row">
            <label class="col-sm-2 col-form-label">Address</label>
            <div class="col-md-10">
              <input type="text" name="cusCode" class="form-control">
            </div>
          </div>
          <div class="form-group  row">
            <label class="col-sm-2 col-form-label">Tax ID</label>
            <div class="col-md-4">
              <input type="text" name="cusCode" class="form-control">
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-5">
      <div class="ibox ">
        <div class="ibox-title">
          <h2>Type</h2>
          <div class="ibox-tools"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></div>
        </div>
        <div class="ibox-content">
          <div class="form-group  row">
            <label class="col-sm-2 col-form-label">Sales</label>
            <div class="col-md-4">
              <div class="col-sm-10">
                <label class="checkbox-inline i-checks">
                  <input type="radio" name="status" value="option1" checked>
                  ภ.ง.ด. 1ก </label>
                <label class="i-checks">
                  <input type="radio" name="status" value="option2">
                  ภ.ง.ด. 2</label>
                <label class="i-checks">
                  <input type="radio" name="status" value="option2">
                  ภ.ง.ด. 3</label>
                <label class="i-checks">
                  <input type="radio" name="status" value="option2">
                  ภ.ง.ด. 53</label>
              </div>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-lg-2 col-form-label">Note</label>
            <div class="col-md-10">
              <textarea class="form-control"></textarea>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-12">
      <div class="ibox ">
        <div class="ibox-title">
          <h2>Detail</h2>
          <div class="ibox-tools"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></div>
        </div>
        <div class="ibox-content">
          <div class="form-group">
            <div class="table-responsive">
              <table class="table" width="100%">
                <thead>
                  <tr>
                    <th style="width:5%">No.</th>
                    <th style="width:50%">ประเภทเงินได้พึงประเมินที่จ่าย</th>
                    <th style="width:10%">วัน/เดือน/ปี</th>
                    <th style="width:10%">จำนวนเงิน</th>
                    <th style="width:10%"><span style="width:25%">ภาษีหักนำส่ง</span></th>
                  </tr>
                </thead>
                <tbody>
                  <tr class="gradeX">
                    <td>1</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td class="center"><input type="number" name="cusCode2" class="form-control" value="20"></td>
                    <td class="center"><input type="number" name="cusCode" class="form-control" value="20"></td>
                  </tr>
                  <tr class="gradeX">
                    <td>2</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td class="center"><input type="number" name="cusCode3" class="form-control" value="20"></td>
                    <td class="center"><input type="number" name="cusCode" class="form-control" value="20"></td>
                  </tr>
                  <tr class="gradeX">
                    <td>3</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td class="center"><input type="number" name="cusCode4" class="form-control" value="20"></td>
                    <td class="center"><input type="number" name="cusCode" class="form-control" value="20"></td>
                  </tr>
                  <tr class="gradeX">
                    <td colspan="2">ตัวอักษร</td>
                    <td>รวม</td>
                    <td class="center"><input type="number" name="cusCode5" class="form-control" value="20"></td>
                    <td class="center"><input type="number" name="cusCode6" class="form-control" value="20"></td>
                  </tr>
                </tbody>
                <tfoot>
                </tfoot>
              </table>
            </div>

            <div class="form-group row">
              <div class="col-md-3"><input type="checkbox" name="checkbox" id="checkbox" class="i-checks">
                เข้ากองทุนสำรองเลี้ยงชีพ ใบอนุญาตเลขที่ <input type="text" name="cusCode" class="form-control">
              </div>
              <div class="col-md-2">
                จำนวนเงิน <input type="number" name="cusCode" class="form-control">
              </div>
            </div>

            <div class="form-group row">
              <div class="col-md-3"><input type="checkbox" name="checkbox" id="checkbox" class="i-checks">
                เงินสมทบจ่ายเข้ากองทุนประกันสังคม จำนวนเงิน <input type="number" name="cusCode" class="form-control">
              </div>
            </div>




          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-12">
      <div class="ibox ">
        <div class="ibox-title">
          <h2>Action</h2>
        </div>
        <div class="ibox-content">
          <div class="form-group  row">
            <label class="col-sm-2 col-form-label">Create By</label>
            <div class="col-sm-10">
              <label>admin 1/1/2021 : 03:12:20</label>
            </div>
          </div>
          <div class="form-group  row">
            <label class="col-sm-2 col-form-label">Update By</label>
            <div class="col-sm-10">
              <label>admin 1/1/2021 : 03:12:20</label>
            </div>
          </div>
          <div class="hr-line-dashed"></div>
          <div class="form-group row">
            <div class="col-sm-10 col-sm-offset-2">
              <button name="back" class="btn btn-white" type="button" onclick="window.location='withholding_tax'"><i class="fa fa-reply"></i> Back</button>
              <button class="btn btn-primary " type="submit"><i class="fa fa-save"></i> Save</button>
              <button class="btn btn-success " type="submit"><i class="fa fa-check"></i> Approve</button>
              <button class="btn btn-white " type="submit"><i class="fa fa-print"></i> Print</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <br>
</div>
<!--  END Body-->