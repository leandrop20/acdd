function getAccessCam()
{
	// Grab elements, create settings, etc.
	var video = document.getElementById('video');
	var mediaConfig =  { video: { width:118, height:157 } };
    var errBack = function(e) {
       	console.log('An error has occurred!', e)
    };

	// Get access to the camera!
	if(navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
	    // Not adding `{ audio: true }` since we only want video now
	    navigator.mediaDevices.getUserMedia(mediaConfig).then(function(stream) {
	        video.src = window.URL.createObjectURL(stream);
	        video.play();
	        callResult();
	    });
	}
	/* Legacy code below: getUserMedia */
	else if(navigator.getUserMedia) { // Standard
	    navigator.getUserMedia(mediaConfig, function(stream) {
	        video.src = stream;
	        video.play();
	        callResult();
	    }, errBack);
	} else if(navigator.webkitGetUserMedia) { // WebKit-prefixed
	    navigator.webkitGetUserMedia(mediaConfig, function(stream){
	        video.src = window.webkitURL.createObjectURL(stream);
	        video.play();
	        camAvailable = true;
	        callResult();
	    }, errBack);
	} else if(navigator.mozGetUserMedia) { // Mozilla-prefixed
	    navigator.mozGetUserMedia(mediaConfig, function(stream){
	        video.src = window.URL.createObjectURL(stream);
	        video.play();
	        callResult();
	    }, errBack);
	}
	function callResult()
	{
		$('#btnCapture').show();
	}
}

function capture()
{
	var canvas = document.getElementById('canvas');
	var context = canvas.getContext('2d');
	var video = document.getElementById('video');
	context.drawImage(video, 35, 10, 110, 140, 0, 0, 118, 157);
	$('#btnSaveCapture').show();
}
function saveCapture(id, table)
{
	// Generate the image data
    var img = document.getElementById("canvas").toDataURL("image/png");
    img = img.replace(/^data:image\/(png|jpg);base64,/, "");
    $('#btnSaveCapture').attr("disabled", "disabled");
    
    $.ajax({
    	type: 'POST',
    	url: "../../"+ table +"/saveImage",
    	data: JSON.parse('{ "img" : "'+ img +'", "id" : "'+ id +'" }'),
    	// contentType: 'application/json; charset=utf-8',
        dataType: 'json',
        success: function (e) {
            console.log('saved success: '+JSON.stringify(e));
            location.reload();
        },
        error: function (e) {
        	console.log('error: '+JSON.stringify(e));
        }
    });
}