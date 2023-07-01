<?php
if(isset($_POST['download'])){
    $imgUrl = $_POST['imgurl'];
    $ch = curl_init($imgUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
    $download = curl_exec($ch);
    curl_close($ch);
    header('Content-type: image/jpg');
    header('Content-Disposition: attachment; filename="thumbnail.jpg"');
    echo $download;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thumbnail downloader</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
        <header>Download youtube video thumbnail</header>
        <div class="url-input">
            <span class="title">Paste video url:</span>
            <div class="field">
                <input type="text" placeholder="https://youtu.be/FucPPCPDd2Y?list=PLpwngcHZlPaf1aw42OGyitm4jh2Dlmi9c" required>
                <input type="hidden" class="hidden-input" name="imgurl">
                <div class="bottom-line"></div>
            </div>
        </div>
        <div class="preview-area">
            <img class="thumbnail" src="#" alt="thumbnail">
            <i class="fas fa-cloud-download-alt icon"></i>
            <span>Paste video url to see preview</span>
        </div>
        <button class="download-btn" type="submit" name="download">Download</button>
    </form>

    <script>
        const urlField = document.querySelector(".field input"),
        previewArea=document.querySelector(".preview-area"),
        imgTag=previewArea.querySelector(".thumbnail"),
        hiddenInput=document.querySelector(".hidden-input");


        urlField.onkeyup=()=>{
            let imgUrl = urlField.value;
            previewArea.classList.add("active");

            if(imgUrl.indexOf("https://www.youtube.com/watch?v=") != -1){
                let vidId= imgUrl.split("v=")[1].substring(0,11);
                let ytThumbUrl = `https://img.youtube.com/vi/${vidId}/maxresdefault.jpg`;
                imgTag.src=ytThumbUrl;
            }else if(imgUrl.indexOf("https://www.youtu.be/") != -1){
                let vidId= imgUrl.split("be/")[1].substring(0,11);
                let ytThumbUrl = `https://img.youtube.com/vi/${vidId}/maxresdefault.jpg`;
                imgTag.src=ytThumbUrl;
            }else if(imgUrl.match(/\.(jpe?g|png|gif|bmp|webp)$/1)){
                imgTag.src=imgUrl;
            }else{
                imgTag.src="";
                previewArea.classList.remove("active");
            }
            hiddenInput.value=imgTag.src;
        }
    </script>
    
</body>
</html>