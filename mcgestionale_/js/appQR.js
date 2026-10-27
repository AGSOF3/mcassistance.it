var app = new Vue({
  el: '#app',
  data: {
    scanner: null,
    activeCameraId: null,
    cameras: [],
    scans: []
  },
  mounted: function () {
    var self = this;
    self.scanner = new Instascan.Scanner({ video: document.getElementById('preview'), scanPeriod: 1 });
    self.scanner.addListener('scan', function (content, image) {
      self.scans.unshift({ date: +(Date.now()), content: content });
      
      document.getElementById("dipQR").value = content;

       document.getElementById("formUtente").submit();
    });
    Instascan.Camera.getCameras().then(function (cameras) {
      self.cameras = cameras;
      if (cameras.length > 0) {
        self.activeCameraId = cameras[0].id;
        self.scanner.start(cameras[0]);
      } else {
        console.error('No cameras found.');
      }
    }).catch(function (e) {
      console.error(e);
    });
  },
  methods: {
    formatName: function (name) {
      return name || '(unknown)';
    },
    selectCamera: function (camera) {
      this.activeCameraId = camera.id;
      this.scanner.start(camera);
    }
  }
});

function apriImpostazioni(){
  window.open("impostazioniQR.php","Impostazioni QR","width=450,height=400");
}

function impostazioniQROL(){
  window.moveTo(400,150);
  window.focus();
  mostraContrVoce();
}

function mostraContrVoce(){
	if(document.getElementById("suoniConferma").value == 'V'){
		document.getElementById("controlliVoce").style.display = "block";
	}else{
		document.getElementById("controlliVoce").style.display = "none";
	}
}

