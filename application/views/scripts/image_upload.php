<html>
<head>
<script type='text/javascript'>
function encodeImageFileAsURL(){

    var filesSelected = document.getElementById("inputFileToLoad").files;
    if (filesSelected.length > 0)
    {
        var fileToLoad = filesSelected[0];

        var fileReader = new FileReader();

        fileReader.onload = function(fileLoadedEvent) {
            var srcData = fileLoadedEvent.target.result; // <--- data: base64
            var newImage = document.createElement('img');
			newImage.name = "file_name";
            newImage.src = srcData;

            document.getElementById("imgTest").innerHTML = newImage.outerHTML;
			document.getElementById("input_box").value = srcData.replace("data:image/jpeg;base64,", "");
			
            //alert("Converted Base64 version is "+document.getElementById("imgTest").innerHTML);
            console.log("Converted Base64 version is "+document.getElementById("imgTest").innerHTML);
        }
        fileReader.readAsDataURL(fileToLoad);
    }
}
</script>
</head>
<body>
<form method="post" action="<?="/api/test/"?>" enctype="multipart/form-data">
<input type="hidden" value="ddcd" name="input_box" id="input_box" />
<input id="inputFileToLoad" type="file" name="file_file" onChange="encodeImageFileAsURL();" />
<div id="imgTest"></div>
<input type="submit" />
</form>
</body>
</html>
