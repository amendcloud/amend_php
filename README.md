Amend
==========

amend is a cloud-based service that provides an end-to-end image management solution including uploads, storage, manipulations, optimizations and delivery.

With amend you can easily upload images to the cloud, automatically perform smart image manipulations without installing any complex software. All your images are then seamlessly delivered through a fast CDN, optimized and using industry best practices. amend offers comprehensive APIs and administration capabilities and is easy to integrate with new and existing web and mobile applications.

amend offers comprehensive APIs and administration capabilities and is easy to integrate with any web application, existing or new.

amend provides URL and HTTP based APIs that can be easily integrated with any Web development framework. 

For projects based on PHP Framework, amend provides a library for simplifying the integration even further.

## Getting started guide
[Getting started guide for PHP]

## Setup ######################################################################

amend Android library is available at [http://amendcloud.com/library/amend_php.zip](http://amendcloud.com/library/amend_php.zip)

### Manual setup

1. Go to [http://amendcloud.com/library/amend_php.zip](http://amendcloud.com/library/amend_php.zip) and download android library.
2. Library is a ZIP archive that could be extracted using any unzip tool.
3. Include Amend.php in your file.

## Try it right away

Sign up for a [free account](http://developer.amendcloud.com/Register) so you can try out image transformations and seamless image delivery through CDN.

*Note: Replace `demo` in all the following examples with your amend's `amend name`.*  

Accessing an uploaded image with the `pc` public ID through a CDN:

    http://amend.cloud/demo/image/pc.jpg

![Sample](http://amend.cloud/demo/image/w_300/pc.jpg "Sample")

Generating a 150x100 version of the `pc` image and downloading it through a CDN:

    http://amend.cloud/demo/image/w_150,h_100,fit_fill/pc.jpg

![Sample 150x100](http://amend.cloud/demo/image/w_150,h_100,fit_fill/pc.jpg "Sample 150x100")

Converting to a 150x100 PNG with rounded corners of 25 pixels: 

    http://amend.cloud/demo/image/w_150,h_100,fit_fill/r_25/pc.jpg

![Sample 150x150 Rounded PNG](http://amend.cloud/demo/image/w_150,h_100,fit_fill/r_25/pc.jpg "Sample 150x150 Rounded PNG")

For plenty more transformation options, see our [image transformations documentation](http://amend.com/documentation/image_transformations).
 
## Usage

### Configuration

Each request for building a URL of a remote cloud resource must have the `amend_name` parameter set. 
Each request to our secure APIs (e.g., image uploads) must have the `access_key` and `access_secret` parameters set. 


Setting the `amend_name`, `access_key` and `access_secret` parameters can be done either directly in each call to a amend  method, 
by when initializing the amend object.

The main entry point of the library is the Amend object.

	Amend::config(array(
		"amendName" => "your-amendName",
		"accessKey" => "your-accessKey",
		"accessSecret" => "your-accessSecret")
	);


### Upload

Assuming you have your amend configuration parameters defined (`amend_name`, `access_key`, `access_secret`), uploading to amend is very simple.
    
The following example uploads a file to the cloud: 

	 $fileContents =  file_get_contents($_FILES['fileToUpload']['tmp_name']); 
			
     $resp = Amend::upload($fileContents);
   
you can get Image Name return by amend upload api 

	$myImage = $resp['ImageName'];	

You can also specify your own Image Name:    
    
    A$fileContents =  file_get_contents($_FILES['fileToUpload']['tmp_name']); 
			
     $resp = Amend::upload($fileContents, "myFileName");

	
### Embedding and transforming images

Any image uploaded to amend can be transformed and embedded using powerful view helper methods:

The following example generates the url for accessing an uploaded `pc` image while transforming it to fill a 100x150 rectangle and set on ImageView img

	$amendOptions = array('transform'=>array('width'=>100','height'=>150,'fit'=>Amend::FIT_FILL));
	echo Amend::load('pc', $amendOptions);

Another example, emedding a smaller version of an uploaded image while generating a 90x90 face detection based thumbnail: 

	$amendOptions = array('transform'=>array('width'=>100','height'=>150,'fit'=>Amend::FIT_FACE));
	echo Amend::load('women', $amendOptions);
	  
  
## Additional resources

Additional resources are available at:

* [Website](http://amendcloud.com)
* [Documentation](http://amendcloud.com/docs)

## Support

Contact us at [support@amendcloud.com](mailto:support@amendcloud.com)

Or via Twitter: [@amend](https://twitter.com/#!/amendcloud)