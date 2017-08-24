$('.files-list').on('click', 'li div', function(e) {
var li = $(this).closest('li');
var id = $(li).attr('data-index');
var type = $(li).attr('data-type');
if(type=='file'){
	return false;
} else {
	$.ajax({
            url: 'openfolder',
            type: 'POST',
            dataType: 'json',
            data: {id: id},
            success: function(data){

				//update breadcrumbs
				getBreadcrumbs(data.curDirPath, data.curDirID);
				
				//dra new files table
				getGridFiles(data.files);
				showTools();
				deleteFile();
				renameFile();
		
            }
    });
}
	
	return false;

});


//open confirm delete dialog
function deleteFile(){
$('.formConfirm').on('click', function(e) {
	e.preventDefault();
	var el = $(this).parent();
	var title = el.attr('data-title');
	var msg = el.attr('data-message');
	var dataForm = el.attr('data-form');
	
	$('#formConfirm')
	.find('#frm_body').html(msg)
	.end().find('#frm_title').html(title)
	.end().modal('show');
	
	$('#formConfirm').find('#frm_submit').attr('data-form-id', dataForm);
  });

//process delete and close dialog
$('#formConfirm').on('click', '#frm_submit', function(e) {
	var itemid = $(this).attr('data-form-id');
	var curDirID = getCurrentDirID();

	$(".modal .close").click();
	$.ajax({
		url: 'deletemedia',
		type: 'POST',
		dataType: 'json',
		data: {id: itemid, curDirID: curDirID},
		success: function(data){
			getGridFiles(data.files);
			showTools();
			deleteFile();
			renameFile();
		}
		
	}); 
});

}

function renameFile(){
//open confirm rename dialog
$('.formRename').on('click', function(e) {
	e.preventDefault();
	var el = $(this).parent();
	var title = el.attr('data-title');
	var msg = el.attr('data-message');
	var dataForm = el.attr('data-form');
	
	$('#formRename')
	.find('#frm_body')
	.end().find('#frm_title').html(title)
	.end().modal('show');
	
	$('#formRename').find('#renameDirSubmit').attr('data-form-id', dataForm);
  });

//process rename and close dialog
$("form#formRename").submit(function(e){
	e.preventDefault();
    var formData = new FormData($(this)[0]);
	var itemid = $(this).find("button#renameDirSubmit").attr('data-form-id');
	formData.append('id', itemid);
	$(".modal .close").click();
	$.ajax({
       url: 'renamemedia',
       type: 'POST',
       data: formData,
       cache: false,
       contentType: false,
       enctype: 'multipart/form-data',
       processData: false,
       success: function (data) {
		   alert(data.files);
		   /* if(data.result=='fail'){
				$('.fail').show();
				$('.fail strong').html(data.message);
			} else{
				getGridFiles(data.files);
				$(".modal .close").click();
			} */
       }
   });
   return false;
	
});
}

$("document").ready(function() {

  showTools();
  deleteFile();
  renameFile();

  $("#adUploadFile").change(function() {
    $('form#uploadFile').submit();
  });
  
});
  
  
  
  // upload form 
   $("#uploadFile").submit(function(e){	 
	  e.preventDefault();
	  var formData = new FormData($(this)[0]);
	  
	  var curDirID = getCurrentDirID();
	  formData.append('curDirID', curDirID);
	  
   $.ajax({
       url: 'fileUpload',
       type: 'POST',
       data: formData,
       cache: false,
       contentType: false,
       enctype: 'multipart/form-data',
       processData: false,
       success: function (data) {
		    if(data.result=='fail'){
				$('.fail').show();
				$('.fail strong').html(data.message);
			} else{
				getGridFiles(data.files);
				showTools();
				deleteFile();
				renameFile();
			}
			
       }
   });
   return false;
 });
 
 
 //draw new grid
 function getGridFiles(files){
	 
	 var wrapper = $('.files-list');
						wrapper.empty();
						$.each( files, function( key, file ) {
						var list = '';
							
							list='<li data-type="' + file['type'] + '" data-index="' + file['id'] + '" class="dir-item"><div><span><i class="fa fa-' + file['type'] + '-o" aria-hidden="true"></i></span><span class="file-name">' + file['name'] + '</span></div><span class="file-tools" style="display: none;"><button class="btn btn-xs no-bg" type="button" data-form="' + file['id'] + '" data-title="Rename ' + file['name'] + '" data-message="Rename ' + file['name'] + ' ?"><a class="formRename" href=""><i class="fa fa-pencil" aria-hidden="true"></i></a></button><form method="POST" action="http://localhost:8080/blog/public/editmedia" accept-charset="UTF-8" style="display:none" id="#edit-form-' + file['id'] + '"><input name="id" type="text" value="' + file['id'] + '"></form><button class="btn btn-xs no-bg" type="button" data-form="' + file['id'] + '" data-title="Delete ' + file['name'] + '" data-message="Are you sure you want to delete ' + file['name'] + ' ?"><a class="formConfirm" href=""><i class="fa fa-trash-o" aria-hidden="true"></i></a></button></span><form method="POST" action="http://localhost:8080/blog/public/deletemedia" accept-charset="UTF-8" style="display:none" id="#delete-form-' + file['id'] + '"><input name="id" type="text" value="' + file['id'] + '"></form></li>';
						
						wrapper.append(list);

	});
	 
 }
 
 //find current working Directory
 function getCurrentDirID(){
	 
	var curDir = $(".breadcrumbs").find("span").attr("curent-dir");
	
	return curDir;
	
 }
 
 
 //breadcrumbs
  function getBreadcrumbs(paths,curDirID){
	  
	  var breadcrumbs = $('.breadcrumbs');
	  var paths = generateBreadcrumbs(paths);
	  
	  breadcrumbs.empty();
	  
	  $.each( paths, function( key, path ) { 
		var breadlist = '';
						
		name =  path.substring(path.lastIndexOf("/")+1);
		if(name.length>0){
			if(key===paths.length - 1){
				breadlist = '<span curent-dir="' + curDirID + '">' + name + '</span>';	
			} else {	
				breadlist = '<a class="breadcrumbs-link" href="" data-folder="' + path + '">' + name + '</a>';
			} 
		}
						
						
		breadcrumbs.append(breadlist);	
	});
	
	 
 }
 
 function generateBreadcrumbs(nextDir){
	var path = nextDir.split('/').slice(0);
	for(var i=1;i<path.length;i++){
		path[i] = path[i-1]+ '/' +path[i];
	}
	return path;
	
}

//when breadcrumb link clicked
$('.breadcrumbs').on('click', 'a[data-folder]', function(e) {
	e.preventDefault();
	var pathTo = ($(this).attr('data-folder'));
	
	$.ajax({
		url: 'breadclicked',
		type: 'POST',
		dataType: 'json',
		data: {path: pathTo},
		success: function(data){
		
			//update breadcrumbs
			getBreadcrumbs(data.curDirPath, data.curDirID);
					
			//draw new files table
			getGridFiles(data.files);
			showTools();
			deleteFile();
			renameFile();
			
		}
		
	}); 
	
});


//breadcrumbs end


//create folder
$("#createDir").submit(function(e){
	e.preventDefault();
    var formData = new FormData($(this)[0]);
	var curDirID = getCurrentDirID();
	formData.append('curDirID', curDirID);
	$.ajax({
       url: 'createdir',
       type: 'POST',
       data: formData,
       cache: false,
       contentType: false,
       enctype: 'multipart/form-data',
       processData: false,
       success: function (data) {
		   if(data.result=='fail'){
				$('.fail').show();
				$('.fail strong').html(data.message);
			} else{
				getGridFiles(data.files);
				$(".modal .close").click();
				showTools();
				deleteFile();
				renameFile();
			}
       }
   });
   return false;
	
});

$('.file-tools').hide();

//on hover show tools

function showTools(){
	$("li").on('mouseenter', function( event ) {
		$(".file-tools", this).stop(true,true).show(0);
	}).on('mouseleave',  function( event ) {
		$(".file-tools", this).stop(true,true).hide(0);
	});
}

// AD Import
$("document").ready(function() {

	$("#fetchusers").click(function() {
		$('form#fetchusersfromad').submit();
	});
	
	$("#importUsers").click(function() {
		$('form#importSelectedUsers').submit();
	});

});



$("#importSelectedUsers").submit(function(e){
	e.preventDefault();
	var formData = new FormData($(this)[0]);
	
	var ch_data = new Array();
	
	$('input[type="checkbox"]:checked').each(function(){
	  ch_data.push($(this).attr('value'));
	});
	
	var json_arr = JSON.stringify(ch_data);
	
	formData.append('checkboxes', json_arr);

	$.ajax({
       url: 'importselectedusers',
       type: 'POST',
	   data: formData,
       cache: false,
       contentType: false,
       enctype: 'multipart/form-data',
       processData: false,
       success: function (data) {
			
			$.each(data.users, function(index, value) {
				
				$('td:contains(' + value + ')').each(function(){
					
					var tr = $(this).parent('tr');
					
					tr.addClass("already-imported");
					tr.find('input').addClass("hide");
				
				});
			});
			
		
		
       }
   });
   
   return false;
	
})


	$(document).ready(function() {
		$('#usersTable').DataTable();

} );




