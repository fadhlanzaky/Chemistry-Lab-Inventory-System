<?php
include('session.php');
if(!isset($_SESSION['login_user'])){
header("location: index.php"); // Redirecting To Home Page
}
?>
<!DOCTYPE html>
<html >
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <link rel="stylesheet" href="css/style-new.css">
   <style>
        /* In order to place the tracking correctly */
        canvas.drawing, canvas.drawingBuffer {
            position: absolute;
            left: 0;
            top: 100;
			margin-left: 100px;
			
        }
   </style>
   <script type="text/javascript">
		function checkAvailability() {
		jQuery.ajax({
		url: "checkdata.php",
		data:'no_id='+$("#no_id").val(),
		type: "POST",
		success:function(data){
			$("#user-availability-status").html(data);
			if (data == "Registered" ){
				$("#next").prop('disabled', true);
			}else{
				$("#next").prop('disabled', false);
			}
		},
		error:function (){}
		});
		}
	</script>
	
  <title>Add New</title>
  
  <link rel="stylesheet" href="css/reset.min.css">

  
</head>

<body>

<div class="container">
<div class="sub-container">
    <h1>Add New Material</h1>
</div>
<div class="sub-container1">
  <!-- multistep form -->
<form id="msform" action="plus.php" method="POST">
  <!-- progressbar -->
  <ul id="progressbar">
    <li class="active"></li>
    <li></li>
    <li></li>
  </ul>
  <!-- fieldsets -->
  <fieldset>
    <h2 class="fs-title">Chemical Profile</h2>
    <h3 class="fs-subtitle">insert ID, Name, and Nomat</h3>
    <h3 class="direction">Press the camera button to scan</h3>
	<div id="scanner-container"></div>
	<div class="container-button">
		<img src="css/icon/cam.svg" width="50px"/>
		<input type="button" id="buttonn" class="btn"/>
	</div>
    <input type="text" class="barcode" name="no_id" placeholder="Barcode ID" id="no_id" onfocus="checkAvailability()" required />
	<span id="user-availability-status"></span>
    <input type="text" class="inputer" name="chemical_name" placeholder="Chemical Name" required />
    <input type="text" class="inputer" name="nomat" placeholder="Nomat" />
    <input type="button" id="next" name="next" class="next action-button" value="Next"/>
  </fieldset>
  <fieldset>
    <h2 class="fs-title">Other Information</h2>
    <h3 class="fs-subtitle">Information brand, location, and expire date</h3>
    <h3 class="direction">Please fill in product details</h3>
    <input type="text" class="inputer" name="brand" placeholder="Brand" />
    <input type="text" class="inputer" name="loc" placeholder="Location in Cabinet" />
    <input type="text" class="inputer" name="exp_date" placeholder="Exp date: YYYYMMDD" pattern="([1-9][0-9][0-9][0-9]([0][1-9]|[1][0-2])([0-2][0-9]|[3][0-1]))" required />
    <input type="button" name="previous" class="previous action-button" value="Previous" />
    <input type="button" name="next" class="next action-button" value="Next" />
  </fieldset>
  <fieldset>
    <h2 class="fs-title">Stock Information</h2>
    <h3 class="fs-subtitle">Chemical stock information</h3>
    <h3 class="direction">Please fill in product details</h3>
    <input type="number" class="inputer" name="min_stock" placeholder="Minimal Stock" required />
    <input type="text" class="inputer" name="unit" placeholder="gr/btl" required />
    <input type="number" class="inputer" name="first_stock" placeholder="First Stock" required />
    <input type="button" name="previous" class="previous action-button" value="Previous" />
    <input type="submit" name="submit" class="action-button" value="Submit" />
  </fieldset>
</form>
</div>
</div>
<script src='js/jquery-new.min.js'></script>
<script src='js/jquery.easing.min.js'></script>
<script src="js/index-new.js"></script>

<!-- Div to show the scanner -->
   

    <!-- Include the image-diff library -->
    <script src="js/quagga.min.js"></script>

    <script>
        var _scannerIsRunning = false;

        function startScanner() {
            Quagga.init({
                inputStream: {
                    name: "Live",
                    type: "LiveStream",
                    target: document.querySelector('#scanner-container'),
                    constraints: {
                        width: 320,
                        height: 180,
                        facingMode: "environment"
                    },
                },
                decoder: {
                    readers: [
                        "code_128_reader",
                        "ean_reader",
                        "ean_8_reader",
                        "code_39_reader",
                        "code_39_vin_reader",
                        "codabar_reader",
                        "upc_reader",
                        "upc_e_reader",
                        "i2of5_reader"
                    ],
                    debug: {
                        showCanvas: true,
                        showPatches: true,
                        showFoundPatches: true,
                        showSkeleton: true,
                        showLabels: true,
                        showPatchLabels: true,
                        showRemainingPatchLabels: true,
                        boxFromPatches: {
                            showTransformed: true,
                            showTransformedBox: true,
                            showBB: true
                        }
                    }
                },

            }, function (err) {
                if (err) {
                    console.log(err);
                    return
                }

                console.log("Initialization finished. Ready to start");
                Quagga.start();

                // Set flag to is running
                _scannerIsRunning = true;
            });

            Quagga.onProcessed(function (result) {
                var drawingCtx = Quagga.canvas.ctx.overlay,
                drawingCanvas = Quagga.canvas.dom.overlay;

                if (result) {
                    if (result.boxes) {
                        drawingCtx.clearRect(0, 0, parseInt(drawingCanvas.getAttribute("width")), parseInt(drawingCanvas.getAttribute("height")));
                        result.boxes.filter(function (box) {
                            return box !== result.box;
                        }).forEach(function (box) {
                            Quagga.ImageDebug.drawPath(box, { x: 0, y: 1 }, drawingCtx, { color: "green", lineWidth: 2 });
                        });
                    }

                    if (result.box) {
                        Quagga.ImageDebug.drawPath(result.box, { x: 0, y: 1 }, drawingCtx, { color: "#00F", lineWidth: 2 });
                    }

                    if (result.codeResult && result.codeResult.code) {
                        Quagga.ImageDebug.drawPath(result.line, { x: 'x', y: 'y' }, drawingCtx, { color: 'red', lineWidth: 3 });
                    }
                }
            });


            Quagga.onDetected(function (result) {
                //console.log("Barcode detected and processed : [" + result.codeResult.code + "]", result);
				document.getElementById("no_id").value=(result.codeResult.code);
			});
        }


        // Start/stop scanner
        document.getElementById("buttonn").addEventListener("click", function () {
            if (_scannerIsRunning) {
                Quagga.stop();
            } else {
                startScanner();
            }
        }, false);
    </script>

</body>
</html>
