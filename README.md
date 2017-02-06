Amend
==========


Amend is a Platform–as-a-Service (PaaS) solution hosted on cloud. Amend helps you manage your application’s image resources in the cloud without having to worry about scale and performance. The resources are delivered by high-performance servers through Content Delivery Network (CDN).

Resources are uploaded, managed, and transformed using amend’s easy to use APIs and SDKs. Infrastructure used for these operations is infinitely scalable for handling high load and bursts of traffic.

Amend provides URL based APIs and SDKS that can be easily integrated with any Web or Mobile development framework. 

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

*Note: Replace `test` in all the following examples with your amend's `amend name`.*  

Accessing an uploaded image with the `baby` public ID through a CDN:

    http://amend.cloud/test/image/baby

![Sample](http://amend.cloud/test/image/w_300/baby "baby")

Generating a 150x100 version of the `baby` image and downloading it through a CDN:

    http://amend.cloud/test/image/w_150,h_100,fit_fill/baby

![Sample 150x100](http://amend.cloud/test/image/w_150,h_100,fit_fill/baby "baby 150x100")

Converting to a 150x100 PNG with rounded corners of 25 pixels: 

    http://amend.cloud/test/image/w_150,h_100,fit_fill/r_25/baby

![Sample 150x150 Rounded PNG](http://amend.cloud/test/image/w_150,h_100,fit_fill/r_25/baby "baby 150x150 Rounded PNG")

For plenty more transformation options, see our [image transformations documentation](http://amendcloud.com/docs/image_transformation).
 
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

The following example generates the url for accessing an uploaded `baby` image while transforming it to fill a 100x150 rectangle and set on ImageView img

	$amendOptions = array('transform'=>array('width'=>100','height'=>150,'fit'=>Amend::FIT_FILL));
	echo Amend::load('baby', $amendOptions);

Another example, emedding a smaller version of an uploaded image while generating a 90x90 face detection based thumbnail: 

	$amendOptions = array('transform'=>array('width'=>100','height'=>150,'fit'=>Amend::FIT_FACE));
	echo Amend::load('women', $amendOptions);
	  
  
## Additional resources

Additional resources are available at:

* [Website](http://amendcloud.com)
* [Documentation](http://amendcloud.com/docs)

## Support

Contact us at [support@amend.cloud](mailto:support@amend.cloud)

Or via Twitter: [@amend](https://twitter.com/#!/amendcloud)