function msgSuccess(){
              swal({
                title: "Success",
                text: "บันทึกข้อมูลสำเร็จแล้ว",
                type: "success"
              });;
}
function msgUploadSuccess(){
  swal({
    title: "Success",
    text: "อัพโหลดไฟล์สำเร็จแล้ว",
    type: "success"
  });;
}
function msgError(){

              swal({
                title: "Error",
                text: "มีข้อผิดพลาดไม่สามารถดำเนินการดังกล่าวได้",
				  confirmButtonColor: "#DD6B55",
                type: "warning",
              });;
}


function msgDuplicate(){

              swal({
                title: "Error",
                text: "เลขที่ INV No. หรือ Booking No. ซ้ำ",
				  confirmButtonColor: "#DD6B55",
                type: "warning",
              });;
}

function msgNoimg(){

              swal({
                title: "Error",
                text: "กรุณาแนบไฟล์ประกอบ",
				  confirmButtonColor: "#DD6B55",
                type: "warning",
              });;
}
/*
function msgConfirmDel(){

swal({
        title: "Are you sure?",
        text: "กรุณายืนยันการลบข้อมูลของคุณ",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Yes, delete it!",
        closeOnConfirm: false
    }, function () {
        swal("Deleted!", "file has been deleted.", "success");
    });
}
*/




