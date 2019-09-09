<?php
include('session.php');
if(!isset($_SESSION['login_user'])){
header("location: index.php"); // Redirecting To Home Page
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Add Stock</title>
	<link rel="stylesheet" href="css/style-stock.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	<script src='js/jquery-new.min.js'></script>
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
				$("#submit").prop('disabled', false);
			}else{
				$("#submit").prop('disabled', true);
			}
		},
		error:function (){}
		});
		}
	</script>
</head>

<body>
<!-- multistep form -->
<div class="container">
    <div class="sub-container1">
            <h1>Add Stock</h1>
    </div>
    <div class="sub-container2">
<form class="myform" id="msform" action="tambah.php">
  <!-- fieldsets -->
  <fieldset>
    <h3 class="direction">Scan using barcode reader or choose methode</h3>
	<div id="scanner-container"></div>
	<div class="container-button">
            <img src="css/icon/cam.svg" width="50px"/>
		<input type="button" id="buttonn" class="btn"/>
	</div>
	<input class="barcode" type="text" name="no_id" placeholder="Barcode ID" id="no_id" onchange="checkAvailability()" required />
	<span id="user-availability-status"></span>
	<input class="qty" type="number" name="tambah" placeholder="Quantity" id="tambah" required />
	<input class="qty" type="text" name="exp_date" placeholder="Exp date: YYYYMMDD" id="exp_date" required pattern="([1-9][0-9][0-9][0-9]([0][1-9]|[1][0-2])([0-2][0-9]|[3][0-1]))" />
    <input type="submit" name="submit" id="submit" class="submit action-button" value="Submit" />
  </fieldset>
</form>
</div>
</div>
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
