<?php 
	$imageName="";
	$imageUrl="";
	
	if(isset($_GET['ImageUrl'])){
		$imageUrl=$_GET['ImageUrl'];
	}else if(isset($_GET['ImageName'])){
		$imageName=$_GET['ImageName'];
	}else{
		header('location:index.php');
	}
    require_once("lib-amend/amend.php");
	// Amend::config(array(
		// "amendName"=>"your-amendName",
		// "accessKey"=>"your-accessKey",
		// "accessSecret"=>"your-accessSecret")
	// );
	
	$txtHeight = "";
	$txtWidth = "";
	$ddFit = "";
	$ddAlign = "";
	$ddListColor = "";
	$txtOriginX = "";
	$txtOriginY = "";
	$txtBright = "";
	$txtContrast = "";
	$txtOverlayImage = "";
	$txtOverlayText = "";
	$txtOverlayPosX = "";
	$txtOverlayPosY = "";
	$txtTextSize = "";
	$ddTextColor = "";
	$chkBold = false;
	$chkItalic = false;
	$chkFlipX = false;
	$chkFlipY = false;
	$txtRadius = "";
	$txtQuality = "";
	$txtAngle = "";
	$chkInvert = false;
	$chkGrayScale = false;
	$postback=false;
	
	if(isset($_POST['submit'])){
		$postback=true;
		$txtHeight = $_POST['txtHeight'];
		$txtWidth = $_POST['txtWidth'];
		$ddFit = $_POST['ddFit'];
		$ddAlign = $_POST['ddAlign'];
		$ddListColor = $_POST['ddListColor'];
		$txtOriginX = $_POST['txtOriginX'];
		$txtOriginY = $_POST['txtOriginY'];
		$txtBright = $_POST['txtBright'];
		$txtContrast = $_POST['txtContrast'];
		$txtOverlayImage = $_POST['txtOverlayImage'];
		$txtOverlayText = $_POST['txtOverlayText'];
		$txtOverlayPosX = $_POST['txtOverlayPosX'];
		$txtOverlayPosY = $_POST['txtOverlayPosY'];
		$txtTextSize = $_POST['txtTextSize'];
		$ddTextColor = $_POST['ddTextColor'];
		$chkBold = isset($_POST['chkBold']);
		$chkItalic = isset($_POST['chkItalic']);
		$chkFlipX = isset($_POST['chkFlipX']);
		$chkFlipY = isset($_POST['chkFlipY']);
		$txtRadius = $_POST['txtRadius'];
		$txtQuality = $_POST['txtQuality'];
		$txtAngle = $_POST['txtAngle'];
		$chkInvert = isset($_POST['chkInvert']);
		$chkGrayScale = isset($_POST['chkGrayScale']);
		
		$options=array();
		$trans = array();
		if ($txtHeight != '' ){
			$trans["height"]=$txtHeight;
		}
		if($txtWidth!= '') {
			$trans["width"]=$txtWidth;
		}
		if ($ddFit != '0') {
			switch ($ddFit) {
				case '1':
					$trans["fit"]= Amend::FIT_XY;
					break;
				case '2':
					$trans["fit"]= Amend::FIT_WIDTH;
					break;
				case '3':
					$trans["fit"]= Amend::FIT_HEIGHT;
					break;
				case '4':
					$trans["fit"]=Amend::FIT_FILL;
					break;
				case '5':
					$trans["fit"]= Amend::FIT_INSIDE;
					break;
				case '6':
					$trans["fit"]= Amend::FIT_FACE;
					break;
			}
		}
		if ($ddAlign != '0') {
			switch ($ddAlign) {
				case "1":
					$trans["align"]= Amend::LEFT;
					break;
				case "2":
					$trans["align"]=Amend::RIGHT;
					break;
				case "3":
					$trans["align"]= Amend::CENTER;
					break;
				case "4":
					$trans["align"]=Amend::TOP;
					break;
				case "5":
					$trans["align"]= Amend::BOTTOM;
					break;
			}
		}
		if ($ddListColor != '0') {
			$trans["color"]=$ddListColor;
			
		}
		if ($txtOriginX != '') {
			$trans["x"]= $txtOriginX;
		}
		if ($txtOriginY != '') {
			$trans["y"]= $txtOriginY;
		}
		
		$options["transform"]=$trans;
		
		
		$effect = array();
		if ($txtBright != '') {
			$effect["brightness"]=$txtBright;
			
			
		}
		if ($txtContrast != '') {
			$effect["contrast"]=$txtContrast;			
		}
		$options["effect"]=$effect;
		

		//Set options for image overlay
		if ($txtOverlayImage != '') {
			$obj_Overlay = array();
			$obj_Overlay["image"]=$txtOverlayImage;
			
			
			if ($txtOverlayPosX != '') {
				$obj_Overlay["x"]=$txtOverlayPosX;
			}
			if ($txtOverlayPosY != '') {
				$obj_Overlay["y"]=$txtOverlayPosY;
			}
			$options["overlay"]=$obj_Overlay;
		}

		//Set options for text overlay
		if ($txtOverlayText!= '') {
			$obj_overlay_txt = array();
			$obj_overlay_txt["text"]=$txtOverlayText;
			
			if ($txtTextSize != '') {
				$obj_overlay_txt["size"]=$txtTextSize;
			}
			if ($ddTextColor != '0') {
				$obj_overlay_txt["color"]=$ddTextColor;
			}
			if ($chkBold) {
				$obj_overlay_txt["style"]=Amend::BOLD;
			}
			if ($chkItalic) {
				$obj_overlay_txt["style"]=Amend::ITALIC;
			}
			if ($txtOverlayPosX != '') {
				$obj_overlay_txt["x"]=$txtOverlayPosX;
				
			}
			if ($txtOverlayPosY != '') {
				$obj_overlay_txt["y"]=$txtOverlayPosY;
			}
			
			$options["overlay"]=$obj_overlay_txt;
		}

		//Set options for Quality
		if ($txtQuality != '') {
			
			$options["quality"]=$txtQuality;
		}

		//Set options for radius
		if ($txtRadius != '') {
			if ($txtRadius == 'Max') {
				$options["radius"]=Amend::MAX;
			} else {
				$options["radius"]=$txtRadius;
			}
		}

		//Set options for flip effects

		if ($chkFlipX && !$chkFlipY) {
			$options["flip"]=Amend::X;
		} else if(!$chkFlipX && $chkFlipY) {
			$options["flip"]=Amend::Y;
		}else if($chkFlipX && $chkFlipY){
			$options["flip"]=Amend::XY;
		}

		//Set Options for invert
		if ($chkInvert) {
			$options["invert"]=true;
		}

		//Set options for Rotate
		if ($txtAngle!='') {
			$options["rotate"]=$txtAngle;
		}

		//Set options for grayscale
		if ($chkGrayScale) {
			$options["grayscale"]=true;
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
        .radio {
            display: inline-block;
            width: 10%;
        }
    </style>
    <script type="text/javascript">
   
    </script>
</head>
<body>
    <form id="form1" action="" method="post" enctype="multipart/form-data">
        <nav class="navbar navbar-inverse navbar-fixed-top" style="min-height: 62px !important">
            <div class="container-fluid">
                <div class="navbar-header">
                    <a class="navbar-brand" href="index.php">
                        <img alt="Brand" src="Images/amend-logo.png" style="margin-top: -30px; height: 90px; padding: 5px" />
                    </a>
                </div>
            </div>
        </nav>
        <div class="container" style="margin-top: 62px;">
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-2">
                            <h2 class="page-header">Transform</h2>
                            <div class="form-group">
                                <label>Height</label>
                                <input type="number" class="form-control" id="txtHeight" name="txtHeight" value="<?php echo $txtHeight ?>" />
                            </div>
                            <div class="form-group">
                                <label>Width</label>
                                <input type="number" class="form-control" id="txtWidth" name="txtWidth" value="<?php echo $txtWidth ?>"/>
                            </div>
                            <div class="form-group">
                                <label>Fit</label>
                                <select id="ddFit" class="form-control" name="ddFit" value="<?php echo $ddFit ?>">
                                    <option value="0">Fit Option</option>
                                    <option value="1" <?php echo $ddFit=="1"?"selected='selected'":"" ?>>Fit XY</option>
                                    <option value="2" <?php echo $ddFit=="2"?"selected='selected'":"" ?>>Fit Width</option>
                                    <option value="3" <?php echo $ddFit=="3"?"selected='selected'":"" ?>>Fit Height</option>
                                    <option value="4" <?php echo $ddFit=="4"?"selected='selected'":"" ?>>Fit Fill</option>
                                    <option value="5" <?php echo $ddFit=="5"?"selected='selected'":"" ?>>Fit Inside</option>
                                    <option value="6" <?php echo $ddFit=="6"?"selected='selected'":"" ?>>Fit Face</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Align</label>
                                <select class="form-control" id="ddAlign" name="ddAlign" value="<?php echo $ddAlign ?>">
                                    <option value="0">Align Option</option>
                                    <option value="1" <?php echo $ddAlign=="1"?"selected='selected'":"" ?>>Align Left</option>
                                    <option value="2" <?php echo $ddAlign=="2"?"selected='selected'":"" ?>>Align Right</option>
                                    <option value="3" <?php echo $ddAlign=="3"?"selected='selected'":"" ?>>Align Center</option>
                                    <option value="4" <?php echo $ddAlign=="4"?"selected='selected'":"" ?>>Align Top</option>
                                    <option value="5" <?php echo $ddAlign=="5"?"selected='selected'":"" ?>>Align Bottom</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Color</label>
                                <select class="form-control" id="ddListColor" name="ddListColor"  >
                                    <option value="0" >Select Color</option>
                                    <option value="Red" <?php echo $ddListColor=="Red"?"selected='selected'":"" ?> >Red</option>
                                    <option value="Violet" <?php echo $ddListColor=="Violet"?"selected='selected'":"" ?> >Violet</option>
                                    <option value="Blue" <?php echo $ddListColor=="Blue"?"selected='selected'":"" ?>>Blue</option>
                                    <option value="Green" <?php echo $ddListColor=="Green"?"selected='selected'":"" ?>>Green</option>
                                    <option value="Yellow" <?php echo $ddListColor=="Yellow"?"selected='selected'":"" ?>>Yellow</option>
                                    <option value="Sepia" <?php echo $ddListColor=="Sepia"?"selected='selected'":"" ?>>Sepia</option>
                                    <option value="Aqua" <?php echo $ddListColor=="Aqua"?"selected='selected'":"" ?>>Aqua</option>
                                    <option value="Gray" <?php echo $ddListColor=="Gray"?"selected='selected'":"" ?>>Gray</option>
                                    <option value="White" <?php echo $ddListColor=="White"?"selected='selected'":"" ?>>White</option>
                                    <option value="Azure" <?php echo $ddListColor=="Azure"?"selected='selected'":"" ?>>Azure</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Origin X</label>
                                <input type="number" class="form-control" id="txtOriginX" value="<?php echo $txtOriginX ?>" name="txtOriginX"  />
                            </div>
                            <div class="form-group">
                                <label>Origin Y</label>
                                <input type="number" class="form-control" id="txtOriginY" value="<?php echo $txtOriginY ?>" name="txtOriginY" />
                            </div>
                        </div>
                        <div class="col-md-2">
                            <h2 class="page-header">Effects</h2>
                            <div class="form-group">
                                <label>Brightness</label>
                                <input class="form-control" type="number" id="txtBright" value="<?php echo $txtBright ?>" name="txtBright" />
                            </div>
                            <div class="form-group">
                                <label>Contrast</label>
                                <input type="number" class="form-control" id="txtContrast" value="<?php echo $txtContrast ?>" name="txtContrast" />
                            </div>
                        </div>
                        <div class="col-md-2">
                            <h2 class="page-header">Overlay</h2>
                            <div class="form-group">
                                <label>Overlay Image</label>
                                <input type="text" class="form-control" id="txtOverlayImage" value="<?php echo $txtOverlayImage ?>"  name="txtOverlayImage" />
                            </div>
                            <div class="form-group">
                                <label style="width: 100%;">Desired Text</label>
                                <input type="text" class="form-control" id="txtOverlayText" value="<?php echo $txtOverlayText ?>"  name="txtOverlayText" />
                            </div>
                            <div class="form-group">
                                <label>Position(X-Coordinate)</label>
                                <input type="number" class="form-control" id="txtOverlayPosX" value="<?php echo $txtOverlayPosX ?>"  name="txtOverlayPosX" />
                            </div>
                            <div class="form-group">
                                <label>Position(Y-Coordinate)</label>
                                <input type="number" class="form-control" ID="txtOverlayPosY" value="<?php echo $txtOverlayPosY ?>"  name="txtOverlayPosY" />
                            </div>
                            <div class="form-group">
                                <label>Font Size</label>
                                <input type="number" class="form-control" id="txtTextSize" value="<?php echo $txtTextSize ?>"  name="txtTextSize" />
                            </div>
                            <div class="form-group">
                                <label>Text Color</label>
                                <select class="form-control" id="ddTextColor" value="<?php echo $ddTextColor ?>"  name="ddTextColor">
                                   <option value="0" >Select Color</option>
                                   <option value="Red" <?php echo $ddTextColor=="Red"?"selected='selected'":"" ?> >Red</option>
                                    <option value="Violet" <?php echo $ddTextColor=="Violet"?"selected='selected'":"" ?> >Violet</option>
                                    <option value="Blue" <?php echo $ddTextColor=="Blue"?"selected='selected'":"" ?>>Blue</option>
                                    <option value="Green" <?php echo $ddTextColor=="Green"?"selected='selected'":"" ?>>Green</option>
                                    <option value="Yellow" <?php echo $ddTextColor=="Yellow"?"selected='selected'":"" ?>>Yellow</option>
                                    <option value="Sepia" <?php echo $ddTextColor=="Sepia"?"selected='selected'":"" ?>>Sepia</option>
                                    <option value="Aqua" <?php echo $ddTextColor=="Aqua"?"selected='selected'":"" ?>>Aqua</option>
                                    <option value="Gray" <?php echo $ddTextColor=="Gray"?"selected='selected'":"" ?>>Gray</option>
                                    <option value="White" <?php echo $ddTextColor=="White"?"selected='selected'":"" ?>>White</option>
                                    <option value="Azure" <?php echo $ddTextColor=="Azure"?"selected='selected'":"" ?>>Azure</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label style="width: 100%;">Font Style</label>
                                <label class="checkbox-inline">
                                    <input type="checkbox" id="chkBold" <?php echo $chkBold==true?"checked='checked'":"" ?> name="chkBold"/>Bold
                                </label>
                                <label class="checkbox-inline">
                                    <input type="checkbox" id="chkItalic" <?php echo $chkItalic==true?"checked='checked'":"" ?> name="chkItalic"/>Italic
                                </label>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <h2 class="page-header">Flip</h2>
                            <div class="form-group">
                                <label class="checkbox-inline">
                                    <input type="checkbox" id="chkFlipX" <?php echo $chkFlipX==true?"checked='checked'":"" ?> value="" name="chkFlipX"/>Flip X
                                </label>
                            </div>
                            <div class="form-group">
                                <label class="checkbox-inline">
                                    <input type="checkbox" id="chkFlipY" <?php echo $chkFlipY==true?"checked='checked'":"" ?> value="" name="chkFlipY" />Flip Y
                                </label>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <h2 class="page-header">Extras</h2>
                            <div class="form-group">
                                <label>Radius(use 'Max' for max radius)</label>
                                <input type="text" id="txtRadius" class="form-control" value="<?php echo $txtRadius ?>"  name="txtRadius" />
                            </div>
                            <div class="form-group">
                                <label>Quality(Max :100, Min : 0)</label>
                                <input type="number" id="txtQuality" class="form-control" max="100" value="<?php echo $txtQuality ?>"  name="txtQuality" />
                            </div>
                            <div class="form-group">
                                <label>Rotate</label>
                                <input type="number" id="txtAngle" class="form-control" value="<?php echo $txtAngle ?>"  name="txtAngle" />
                            </div>
                            <div class="form-group">
                                <label style="width: 100%;"></label>
                                <label class="checkbox-inline">
                                    <input type="checkbox" id="chkInvert" <?php echo $chkInvert==true?"checked='checked'":"" ?> value="" name="chkInvert"/>Invert
                                </label>
                            </div>
                            <div class="form-group">
                                <label style="width: 100%;"></label>
                                <label class="checkbox-inline">
                                    <input type="checkbox" id="chkGrayScale" <?php echo $chkGrayScale==true?"checked='checked'":"" ?> value="" name="chkGrayScale" />Gray Scale
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4"></div>
                    <div class="col-md-4"></div>
                    <div class="col-md-4">
                        <input type="submit" name="submit" class="btn btn-primary" Style="width: 50%" value="Get Image" id="btnGet"/>
                    </div>
                </div>
                <div class="row" style="margin-left:20px">
                    <h2 class="page-header">Image Preview</h2>
                    <div class="col-xs-12 col-md-12">
                        <a href="#" target="_blank" class="thumbnail">
							<?php if($postback) {
									if($imageName!=""){
										echo Amend::load($imageName,$options);
									}else{
										echo Amend::fetch($imageUrl,$options);
									}
								}
							
							?>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="spinner-container">
            <div class="spinner">
                <div class="bounce1"></div>
                <div class="bounce2"></div>
                <div class="bounce3"></div>
            </div>
        </div>
    </form>
</body>
</html>
