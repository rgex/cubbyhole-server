        
/**
*  @param Array
*
*  @returns String
*/
function pathToString(path) {
	var pathString = path.join('/');
	if(pathString.length > 0)
		pathString = "/" + pathString + "/";
	if(pathString.length === 0)
		pathString = '/';
        return pathString;
}

function gotoFolderInPath(i) {
	currentPath = currentPath.slice(0, i);
	getPathListFromWS(currentPath);
}

function getPathListFromWS(path) {
	if(typeof token !== 'undefined')
		var listUrl = 'path=' + pathToString(path) + '&token=' + token;
	else
		var listUrl = 'path=' + pathToString(path) + '&userId=' + userId;
        $.ajax({
                type: "POST",
                url: wsUrl + 'list',
                data: listUrl,
                success: function(data){
                    displayPath(data,path);
                },
                dataType: 'json'
        });
}
        
function listPath(folder) {
        newPath = currentPath;
        newPath.push(folder);
        getPathListFromWS(currentPath);
}
        
function clickOnFolder(folder){
	listPath(folder);
}

function refreshNaBar() {
	//first remove all previous elements
	$('.navTab').html('');
	$('.navTab').append('<span><a href="#" onclick="gotoFolderInPath(0); return false;">Home</a></span> / ');
	for(var i in currentPath) {
		$('.navTab').append('<li><a href="#" onclick="gotoFolderInPath(' + (i+1) + '); return false;">' + currentPath[i] + '</a></li>');
	}
}

function downloadFile(fileName) {
	window.location.assign(downloadUrl + 'download/?userid=' + userId + '&file=' + pathToString(currentPath) + fileName + '&token=' + token);
}

function displayPath(json,newPath) {
//first remove all previous elements

$('.fileExplorer').html('');
	    
for(i in json) {
	if(json[i][3] === 'priv')
		var publicStatus = '<span class="public">&nbsp;</span>';
	else
		var publicStatus = '<span class="public"><img src="/img/public.png"></span>';

	if(json[i][3] === 'priv')
		var publicStatusAction = '<span class="public"><a href="#" title="Rendre publique" onclick="makePublic(\'' + json[i][1] + '\');"><img src="/img/public.png"></a></span>';
	else
		var publicStatusAction = '<span class="public"><a href="#" title="Rendre privé" onclick="makePrivate(\'' + json[i][1] + '\');"><img src="/img/private.png"></a></span>';

	if(json[i][0] === 'D') { //directory
        	$('.fileExplorer').append('<div class="element element-' + i%2 + '">'+
					  publicStatus +
                                          '<span class="type"><img src="/img/folder.gif"></span>' +
					  '<span class="name"><a href="#" onclick="listPath(\'' + json[i][1] + '\'); return false;">' + json[i][1] + '</a></span>' +
					  publicStatusAction +
					  '<span class="delete"><a href="#" title="Supprimer" onclick="deleteElement(\'' + json[i][1] + '\');"><img src="/img/delete.png"></a></span>' +
					  '<span class="download"></span>' +
 			                  '&nbsp;</div>' +
					  '<div style="clear:both;"></div>');
	}
	else {	//file
		var size = 0;
		if(json[i][2] <= 1000*1000) //si inférieur au méga
			size = Math.ceil(json[i][2]/100)/10 + ' Ko';
		if(json[i][2] <= 1000*1000*1000 && json[i][2] > 1000*1000) //si inférieur au giga
			size = Math.ceil(json[i][2]/100000)/10 + ' Mo';
                $('.fileExplorer').append('<div class="element element-' + i%2 + '">'+
					  publicStatus +
                                          '<span class="type"><img src="/img/file.png"></span>' +
                                          '<span class="name">' + json[i][1] + '</span>' +
					  publicStatusAction +
					  '<span class="delete"><a href="#" title="Supprimer" onclick="deleteElement(\'' + json[i][1] + '\');"><img src="/img/delete.png"></a></span>' +
					  '<span class="download"><a href="#" title="Télécharger" onclick="downloadFile(\'' + json[i][1] + '\'); return false;"><img src="/img/download.png"></a></span>' +
					  '<span class="size">' + size + '</span>' +
                                          '&nbsp;</div>'+
					  '<div style="clear:both;"></div>');
		}
        }
	currentPath = newPath;
	refreshNaBar();
}
        
function createFolder() {
	var folderName = prompt("Please enter the folder name");
	if(folderName.length !== 0) {
		$.ajax({
			type: "POST",
			url: wsUrl + 'createFolder',
			data: 'path=' + pathToString(currentPath) + '&folderName=' + folderName + '&token=' + token,
			success: function(data){
				getPathListFromWS(currentPath);
			},
			dataType: 'json'
		});
	}
}

function makePublic(element) {
	if(confirm('Voulez vous vraiment rendre cet élément public?')) {
		$.ajax({
			type: "POST",
			url: wsUrl + 'makePublic',
			data: 'path=' + pathToString(currentPath) + '&fileName=' + element + '&token=' + token,
			success: function(data){
			    getPathListFromWS(currentPath);
			},
			dataType: 'json'
		});
	}
}

function makePrivate(element) {
	if(confirm('Voulez vous vraiment rendre cet élément privé')) {
		$.ajax({
			type: "POST",
			url: wsUrl + 'makePrivate',
			data: 'path=' + pathToString(currentPath) + '&fileName=' + element + '&token=' + token,
			success: function(data){
			    getPathListFromWS(currentPath);
			},
			dataType: 'json'
		});
	}
}

function deleteElement(element) {
	if(confirm('Voulez vous vraiment supprimer cet élément?')) {
		$.ajax({
			type: "POST",
			url: wsUrl + 'delete',
			data: 'path=' + pathToString(currentPath) + '&fileName=' + element + '&userId=' + userId + '&token=' + token,
			success: function(data){
			    getPathListFromWS(currentPath);
			},
			dataType: 'json'
		});
	}
}

function upload() {/*
	$('#uploadPath').val(currentPath);
	if(currentPath.length === 0)
		$('#uploadPath').val('/');
	$('#uploadProgress').show();*/
}

function loadAjaxForm() {
	$('#uploadForm').ajaxForm({
	beforeSend: function() {
		$('.uploadProgress').show();

		$('.percentage').html('0%');
		$('.progress-bar').attr('aria-valuenow',0);
		$('.progress-bar').css({'width' : '0%'});
	},
	uploadProgress: function(event, position, total, percentComplete) {
		$('.percentage').html(percentComplete + '%');
		$('.progress-bar').attr('aria-valuenow',percentComplete);
		$('.progress-bar').css({'width' : percentComplete + '%'});
	},
	success: function() {
		$('.percentage').html('100%');
		$('.progress-bar').attr('aria-valuenow',100);
		$('.progress-bar').css({'width' : '100%'});
		$('.uploadProgress').slideUp();
		getPathListFromWS(currentPath);
	},
	complete: function(xhr) {
		status.html(xhr.responseText);
	}
	});
}

function closeUploadDiv() {
	$('.upload').slideUp();
	$('.uploadProgress').slideUp();
}

function displayUpload() {
	$('.upload').html(' ');
	$('.upload').append('<div class="fermer"><a href="#" onclick="closeUploadDiv();">Fermer X</a></div>' +
			    '<br>' +
			    '<form action="' + downloadUrl + 'upload" method="POST" enctype="multipart/form-data" id="uploadForm" ' +
			    'onsubmit="$(\'#uploadPath\').val(pathToString(currentPath)); if(currentPath.length === 0) { $(\'#uploadPath\').val(\'/\'); }">' +
			    '<input type="hidden" name="token" value="' + token + '">' +
			    '<input type="hidden" name="path" id="uploadPath">' +
			    '<input type="file" name="file"> &nbsp;' +
			    '<input onclick="upload();" type="submit" value="upload">' +
			    '</form>');
	$('.upload').slideDown();
		setTimeout(function() {
		   	 loadAjaxForm();
	}, 100);
	//loadAjaxForm();
}

$(document).ready(function() {
        getPathListFromWS(currentPath);
});


