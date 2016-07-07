<?php

if (!defined('APP_INIT'))
{
    require_once '../../../init.php';
}

$tab = 'tab5';
$errors = array();
$sent   = 0;

$name       = '';
$email_addr = '';
$phone_num  = '';
$msg_txt    = '';

$result = null;

// @todo: Upgrade Recaptcha when fix is out. Latest is not compatible with IE. It barfs
// if (!isset($browser_info['msie']))
// {
// 	$recaptcha = new Zend_Service_ReCaptcha(RECAPTCHA_PUBLIC_KEY, RECAPTCHA_PRIVATE_KEY);
// }

if (isset($_POST['send']))
{
    $name       = trim(strip_tags($_POST['name']));
    $email_addr = trim(strip_tags($_POST['email']));
    // no longer collecting phone numbers
    //$phone_num  = trim(strip_tags($_POST['phone']));
    $phone_num  = null;
    $msg_txt    = trim(strip_tags($_POST['msg']));

    if (!$name)
    {
        $errors[] = "What's your name?";
    }
    if (!$email_addr)
    {
        $errors[] = 'Your email address is required so I can get back in touch with you';
    }
    if (!$msg_txt)
    {
        $errors[] = "Don't forget about your message";
    }

    if ($email_addr and !is_valid_email_address($email_addr))
    {
        $errors[] = 'Please double check that you entered your email address correctly';
    }

    // Exception thrown when they leave blank
    // if (!isset($browser_info['msie']))
    // {
	  //   try
	  //   {
	  //   	$result = $recaptcha->verify(
  	// 			$_POST['recaptcha_challenge_field'],
  	// 	   	$_POST['recaptcha_response_field']
  	// 		);
	  //   }
	  //   catch (Exception $ex)
	  //   {
	  //   	$errors[] = "Please don't forget to type in your response to the CAPTCHA below";
	  //   }
    //
	  //   if ($result)
	  //   {
		//     if (!$result->isValid())
		// 	{
		// 		$errors[] = 'Please re-type the text exactly as it appears';
		// 	}
	  //   }
    // }

    if (!$errors)
    {
        if ($contact_id = add_contact_request($name, $email_addr, $msg_txt, $phone_num))
        {
            $subject  = '[mikedang.com] New Contact Request';

            $message  = 'Name: '. $name . PHP_EOL;
            $message .= 'Email Address: '. $email_addr . PHP_EOL;
            //$message .= 'Phone Number: '. $phone_num . PHP_EOL;
            $message .= 'IP Address: '. $_SERVER['REMOTE_ADDR'] . PHP_EOL . PHP_EOL;
            $message .= $msg_txt . PHP_EOL;

            $headers  = 'MIME-Version: 1.0'. PHP_EOL;
            $headers .= 'From: '. EML_FROM_ADDRESS . PHP_EOL;

            if (defined('EML_CC_LIST'))
            {
                $headers .= 'Cc: '. EML_CC_LIST . PHP_EOL;
            }

            if (!IS_DEV)
            {
                mail(EML_NOTIFICATION_LIST, $subject, $message, $headers);
            }

            $sent = 1;

            $name       = '';
            $email_addr = '';
            $phone_num  = '';
            $msg_txt    = '';
        }
        else
        {
            $errors[] = 'Sorry, something that shouldn\'t have happened did. I\'ve been notified and will look into it as soon as I can.';
        }
    }
}

if ($sent)
{
    $main_title = 'Message sent!';
}
else
{
    $main_title = 'Wanna chat?';
}

?>

<div id="title">
    <h2><?php echo $main_title ?></h2>
</div>

<div>
<div id="main" class="col-xs-12 col-sm-12 col-md-9">

<?php

if ($sent)
{
    echo <<<SENT
        <div id="success">
            <p>Please allow up to 24 hours for a response as I work full-time during the day, on side projects at night, and attempt to squeeze in a life somewhere in between.</p>
        </div>

SENT;
}
else
{
	if ($errors)
    {
        echo '<h3>Oops! </h3>';
        echo '<ul id="errors">';

        foreach ($errors as $error)
        {
            echo '<li>'. $error .'</li>';
        }

        echo '</ul>';
    }
    else
    {
        echo <<<MESSAGE
            <p>Use the short form below to send me a message about anything you might want to talk about. You can also reach me at any of my profiles to the right. If you don't really have anything to say then just say hi, it still makes me feel special.</p>

MESSAGE;
	    // if (!isset($browser_info['msie']))
	    // {
	    //     echo '<p>I apologize for the <a href="http://en.wikipedia.org/wiki/Captcha" target="_new">CAPTCHA</a>, the spammers are getting out of control. One day we\'ll find a better way.. one day.</p>';
	    // }
    }

?>
<div id="contact-frm">
<div class="footnote">Required fields are denoted by *</div>

<form method="post" id="form" action="/contact/">
    <fieldset>
    	<legend>Contact Information</legend>
        <div>
            <label for="name" class="req">Name *</label>
            <input type="text" id="name" name="name" title="Everyone has a name!" class="required" minlength="3" maxlength="60" value="<?php echo $name ?>" />
        </div>

        <div>
            <label for="email" class="req">Email *</label>
            <input type="text" id="email" name="email" title="Is this a valid email address?" class="required email" maxlength="120" value="<?php echo $email_addr ?>" />
        </div>

        <?php /*
        <div>
            <label for="phone">Phone Number</label>
            <input type="text" id="phone" name="phone" value="<?php echo $phone_num ?>" />
        </div>
        */ ?>
    </fieldset>
    <fieldset>
    	<legend>Your Message</legend>
        <div>
            <textarea id="msg" name="msg" title="What did you want to say?" class="expanding required" maxlength="1000"><?php echo $msg_txt ?></textarea>
        </div>
    </fieldset>
    <?php /* if (!isset($browser_info['msie'])): ?>
      <fieldset>
      	<legend>Are you a human or robot</legend>
      	<?php echo $recaptcha->getHTML(); ?>
      </fieldset>
      <?php endif; */ ?>
    <div id="send-container">
        <input type="submit" name="send" id="send" class="submit large orange" value="Send" />
    </div>
</form>
</div>

<?php } ?>

</div>

<div id="sidebar" class="col-xs-12 col-sm-12 col-md-2">
    <div class="submodule clearfix">
        <h3 class="headline">Let's connect</h3>
        <div class="subcontent">
          <ul>
            <li><i class="fa fa-linkedin fa-lg" aria-hidden="true"></i> &nbsp;<a href="https://www.linkedin.com/in/dangmike" target="_blank">dangmike</a></li>
            <li><i class="fa fa-instagram fa-lg" aria-hidden="true"></i> &nbsp;<a href="https://www.instagram.com/mikedang/" target="_blank">mikedang</a></li>
            <li><i class="fa fa-facebook-square fa-lg" aria-hidden="true"></i> &nbsp;<a href="https://www.facebook.com/dangmike" target="_blank">dangmike</a></li>
            <li><i class="fa fa-twitter fa-lg" aria-hidden="true"></i> &nbsp;<a href="https://twitter.com/mikedang" target="_blank">mikedang</a></li>
            <li><i class="fa fa-500px fa-lg" aria-hidden="true"></i> &nbsp;<a href="https://500px.com/mdang" target="_blank">mdang</a></li>
          </ul>
        </div>
    </div>

    <?php if (DISPLAY_GOOGLE_MAPS): ?>
    <div class="submodule clearfix">
        <h4>Where I Am</h4>
        <div class="subcontent">
            <div id="map"></div>
        </div>
    </div>
    <?php endif; ?>
</div>

<script type="text/javascript">

$(function() {
	selectTab('<?php echo $tab; ?>');
	setPageTitle('<?php echo PAGE_TITLE_BASE . PAGE_TITLE_SEPERATOR . 'Contact Me' ?>');

  var loader = $('<div id="loader">Sending..</div>')
      .css({ position: 'absolute', top: '0', left: '0' })
      .appendTo('body')
      .hide();

  $('#form').validate({});

  //$('#phone').mask('(999) 999-9999', { placeholder:' ' });

  // $('.expanding').autogrow({
  //     maxHeight: 500
  // });

  <?php if (GOOGLE_ANALYTICS_ACCT): ?>
	_gaq.push(['_trackPageview', '/contact/index']);
	<?php endif; ?>
});

</script>

<?php if (DISPLAY_GOOGLE_MAPS): ?>
<script type="text/javascript" src="http://www.google.com/jsapi?key=<?php echo GOOGLE_MAPS_API_KEY ?>"></script>
<script type="text/javascript">
  google.load('maps', '2');

  function initMap() {
      var map = new google.maps.Map2(document.getElementById('map'));
      map.setCenter(new google.maps.LatLng(32.79651, -96.797791), 13);
      map.setZoom(5);

      var point  = new GPoint(-96.797791, 32.79651);
      var marker = new GMarker(point);

      map.addOverlay(marker);
  }

  google.setOnLoadCallback(initMap);

</script>
<?php endif; ?>
