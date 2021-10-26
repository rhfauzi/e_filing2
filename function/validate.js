
function confirmDelete(delUrl) {
	
  if (confirm("ANDA YAKIN INGIN MENGHAPUS DATA ?")) {
    document.location = delUrl;
  }
}

function confirmApprove(appUrl) {
  if (confirm("ANDA YAKIN INGIN MELAKUKAN APPROVE ?")) {
    document.location = appUrl;
  }
}

function OnlyNumb(a)
{
	if(!/^[0-9.]+$/.test(a.value))
	{
	a.value = a.value.substring(0,a.value.length-1000);
	}
}

// function confirmSave(SaveUrl) {
//   if (confirm("ANDA YAKIN DATA SUDAH BENAR ?")) {
//     document.location = SaveUrl;
//   }
// }
