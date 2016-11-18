<?php 
    require_once("lib-amend/amend.php");
	// Amend::config(array(
		// "amendName"=>"your-amendName",
		// "accessKey"=>"your-accessKey",
		// "accessSecret"=>"your-accessSecret")
	// );
?>
<?php
    $error="";
    if(isset($_POST['submit'])){
        $fileContents =  file_get_contents($_FILES['fileToUpload']['tmp_name']);
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
        $uploadOk = 1;

        $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
        // Check if image file is a actual image or fake image
        
        $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
        if($check !== false) {
            $uploadOk = 1;
        } else {
            $uploadOk = 0;
        }
        
        
        // Check file size
        if ($_FILES["fileToUpload"]["size"] > 5500000) {
            echo "Sorry, your file is too large.";
            $uploadOk = 0;
        }

        // Allow certain file formats
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif" ) {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
        // if everything is ok, try to upload file
        } else {
            $fileContents =  file_get_contents($_FILES['fileToUpload']['tmp_name']); 
			
            $resp = Amend::upload($fileContents);
            if($resp['StatusCode']==200){
                header('Location: process.php?ImageName='.$resp['ImageName']);
            }else if(isset($resp['Message'])){
                $error= $resp['Message'];
            }else {
                $error= "Something went wrong";
            }
        }
    }
?>
<!DOCTYPE html>
<html>
<head>
    <title>Amend PHP Sample</title>
    <meta charset="utf-8" />
    <link href="css/bootstrap.css" rel="stylesheet" />
    <link href="css/loader.css" rel="stylesheet" />
    <script src="Scripts/jquery.min.js"></script>
    <style>
        .check {
            background: url(Images/ic_check.png);
            display: inline-block;
            height: 24px;
            width: 24px;
            cursor: pointer;
        }

            .check:hover {
                background: url(Images/checked-hover.png);
                display: inline-block;
                height: 24px;
                width: 24px;
                cursor: pointer;
            }

        .active {
            background: url(Images/checked-hover.png);
            display: inline-block;
            height: 24px;
            width: 24px;
            cursor: pointer;
        }

        .caption {
            text-align: center;
        }
    </style>
    <script type="text/javascript">
        $(document).ready(function () {
            
            $('#btnUploadUrl').click(function () {
                var imgUrl = $('#txtUrl').val();
                if (imgUrl != '') {
                    window.location = "process.php?ImageUrl=" + imgUrl;
                }
            });
        });
    </script>
</head>
<body>
    <form id="form1" action="" method="post" enctype="multipart/form-data">
        <nav class="navbar navbar-inverse navbar-fixed-top" style="min-height: 62px !important">
            <div class="container-fluid">
                <div class="navbar-header">
                    <a class="navbar-brand" href="#">
                        <img alt="Brand" src="images/amend-logo.png" style="margin-top: -30px; height: 90px; padding: 5px" />
                    </a>
                </div>
            </div>
        </nav>
        <div class="jumbotron">
            <div class="container">
                <h3>Please choose any one option for image processing : </h3>
                <hr />
                <div class="row">
                    <div class="col-md-6">
                        <h3>Upload Your Image</h3>
                        <div class="form-group">
                            <label for="exampleInputFile"></label>
                            <input type="file" name="fileToUpload" id="fileToUpload">
                        </div>
                        <input type="submit" id="btnUpload" value="Upload" class="btn btn-primary" name="submit"/>
						<?php
							echo $error;
						?>
                    </div>
                    <div class="col-md-6">
                        <h3>Fetch Image From Url</h3>
                        <div class="form-group">
                            <label for="url">Image Url</label>
                            <input type="url" class="form-control" id="txtUrl" />
                        </div>
                        <input type="button" id="btnUploadUrl" value="Upload" class="btn btn-primary"  />
                    </div>
                   
                </div>
            </div>
        </div>
    </form>
    <div class="spinner-container">
        <div class="spinner">
            <div class="bounce1"></div>
            <div class="bounce2"></div>
            <div class="bounce3"></div>
        </div>
    </div>
</body>
</html>
