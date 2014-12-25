<style type="text/css">
.div_add {
width:450px;
height:500px;
background-image: url('http://i.imgur.com/heVLI.png');
}


input {
    outline:none;
    transition: all 0.25s ease-in-out;
    -webkit-transition: all 0.25s ease-in-out;
    -moz-transition: all 0.25s ease-in-out;
    border-radius:3px;
    -webkit-border-radius:3px;
    -moz-border-radius:3px;
    border:1px solid rgba(0,0,0, 0.2);
    padding:5px;

}

input:focus {
    box-shadow: 0 0 5px rgba(0, 0, 255, 1);
    -webkit-box-shadow: 0 0 5px rgba(0, 0, 255, 1); 
    -moz-box-shadow: 0 0 5px rgba(0, 0, 255, 1);
    border:1px solid rgba(0,0,255, 0.8);
    padding:7px;


}

.button {
    background: url('http://i.imgur.com/gOA8h.png') no-repeat;
    padding: 8 46 7 45;
}


.button:hover {
    background: url('http://i.imgur.com/gOA8h.png') no-repeat;
}

br { clear: left; }

label {
    display: block;
    width: 150px;
    float: left;
    margin: 2px 4px 6px 4px;
    text-align: right;
    font-family:comic sans ms;
    font-size:18px;
}
</style>
<center>
<br />
<div class="div_add">
<form action="" method="post" >
<br />
<?php
session_start();

$error = '';

if(!isset($_SESSION['captcha'])) {
  $_SESSION['captcha'] =  rand(1000,9999);
}

if(isset($_POST['submit'])) {

$_POST = array_map("trim", $_POST);
$_POST = array_map("strip_tags", $_POST);


if($_POST['captcha'] != $_SESSION['captcha'] ) {
$error .= 'Code captcha is incorrect. <br />';
}

if(empty($_POST['nume']) || empty($_POST['email']) || empty($_POST['subiect']) || empty($_POST['mesaj']) || empty($_POST['captcha'])) {
$error .= 'All fields are required. <br />';
}


if(!strstr($_POST['email'],'@')) {
$error .= 'E-mail is incorrect. <br />';
}

function sendmail() {
    $to = 'account@webmaster.com';
    $nume = $_POST['nume'];
    $from = "From: " . $_POST['email']. "";
    $subiect = $_POST['subiect'];
    $mesaj = $_POST['mesaj'];
    $body = 'E-mail de pe site, trimis de: '.$nume. "n Adresa lui /ei de e-mail: ". $from. "nn" .'Mesaj: '.$mesaj;

    if (@mail($to, $subiect, $body, $from)) {
      echo 'Message has succsesfully sent <br />';
      $_SESSION['limit_contact'] = time();
    }else{
      echo 'Error with server';
    }
}


if(isset($_SESSION['limit_contact'])) {

   if($_SESSION['limit_contact']>(time()-20)) {
      $error .= 'Wait '.($_SESSION['limit_contact'] -time()+20).' seconds';
   }else{
      if($error == "")
      sendmail();
   }
}else{
   $_SESSION['limit_contact'] = time();
   if($error == "")
       sendmail();
}

echo $error;                                                                                                                                       # trebuie sa stergi punct si virgula,
}
?>


<br />
<label>Name:</label>            <input type="text" name="nume" id="nume" size="30" maxlength="40" value="<?php if(isset($_POST['nume'])) { echo $_POST['nume'];} ?>" /><br />    <br />
<label>E-mail:</label>          <input type="text" name="email" id="email" size="30" maxlength="58"  value="<?php if(isset($_POST['nume'])) { echo $_POST['nume'];} ?>" /><br />  <br />
<label>Subject:</label>         <input type="text" name="subiect" id="subiect" size="30" maxlength="70"  value="<?php if(isset($_POST['nume'])) { echo $_POST['nume'];} ?>" /><br /> <br />
<label>Message:</label>         <textarea name="mesaj" id="mesaj" cols="26" rows="6"  ></textarea> <br />
<br />
<font size=3> Captcha code:<b> <?php echo $_SESSION['captcha'];?>  &nbsp; </b></font>
<br />
<label>Captcha:</label>         <input type="text" name="captcha" size="30" />  <br />

<br />
<input type="submit" class="button" name="submit" value="" /> <br />

</form>
</div>
</center>
