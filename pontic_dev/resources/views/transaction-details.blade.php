<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Pontic</title>
<style type="text/css">
body {
	background-color: #EEE;
}
</style>
</head>

<body>
<table width="100%" border="0" cellspacing="0" cellpadding="20" bgcolor="#EEE">
  <tr>
    <td  ><table width="600" border="0" align="center" cellpadding="20" cellspacing="0" style="font-family: 'Roboto', sans-serif;">
  <tr>
    <td align="center" valign="middle"  ><img src="{{URL::asset('images/logo-login.png') }}" /></td>
  </tr>
  <tr>
    <td align="center" valign="middle" bgcolor="#FFFFFF" style="border-radius: 3px;"><table width="100%" border="0" cellspacing="0" cellpadding="10" style="color:#333333;">
      <tr>
        <td align="center" style="font-size:24px;">
        Hi {{ $name }},
        </td>
      </tr>
      <tr>
        <td>Thanks for CoNNeCTiNG! The details of your subscription are below.</td>
      </tr>
      <tr> <td>Package Type: {{ $package_type}}</td> </tr>
			<tr> <td>Amount: {{ "$".$amount }}</td>   </tr>  
    </table></td>
  </tr>
  <tr> <td align="center" valign="middle"  bgcolor="#FFFFFF"  >Thank you for your subscription.</td></tr>
  <tr> <td bgcolor="#FFFFFF">-PONTIC<br>contact@pontic.co</td></tr>
  <tr>
    <td align="center" valign="middle"   style="color:#000;">Copyright © 2017 PONTIC, LLC All rights reserved.</td>
  </tr>
</table></td>
  </tr>
</table>


</body>
</html>
