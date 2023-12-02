/*==================== WEB CAM ====================*/
Webcam.set({
    width: 490,
    height: 390,
    image_format: "jpeg",
    jpeg_quality: 60,
  });
  
  function open_cam() {
    Webcam.attach("#my_camera");
  }
  
  function take_snapshot() {
    Webcam.snap(function (data_uri) {
      $(".image-tag").val(data_uri);
      document.getElementById('results').innerHTML = '<img src="' + data_uri + '"/>';
      document.getElementById("profile").innerHTML = document.getElementById("results").innerHTML;
      Webcam.reset();
    });
  }
  
  
  function exit_webcam() {
    document.getElementById("results").innerHTML = '<img src=""/>';
    Webcam.reset();
  }