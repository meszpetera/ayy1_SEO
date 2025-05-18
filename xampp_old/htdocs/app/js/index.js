function initQrReader() {
	cordova.plugins.barcodeScanner.scan(
		function (result) {
			alert(
				"Barcode\n" +
				"Result: " + result.text + "\n" +
				"Format: " + result.format + "\n" +
				"Cancelled: " + result.cancelled
			);
		},
		function (error) {
			alert("Scanning failed: " + error);
		},
		{
			preferFrontCamera : false,
			showFlipCameraButton : true,
			showTorchButton : true,
			torchOn: false,
			saveHistory: true,
			prompt : "Saxon kód beolvasása",
			resultDisplayDuration: 500,
			formats : "QR_CODE,CODE_39",
			orientation : "portrait",
			disableAnimations : true,
			disableSuccessBeep: false
		}
	);
}

var app = {
	initialize: function() {
		document.addEventListener('deviceready', this.onDeviceReady.bind(this), false);
	},
	onDeviceReady: function() {
		this.receivedEvent('app');
	},
	receivedEvent: function(id) {
		var permissions = cordova.plugins.permissions;
		permissions.hasPermission(permissions.CAMERA,
			function(status) {
				if(status.hasPermission) {
					initQrReader();
				} else {
					permissions.requestPermission(
						permissions.CAMERA,
						function() { initQrReader() },
						function() { return false }
					);
				}
			}
		);
	}
};

app.initialize();